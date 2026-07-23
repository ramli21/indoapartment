<?php

namespace App\Services;

use App\DTOs\FonnteMessageData;
use App\Exceptions\FonnteApiException;
use App\Models\FonnteSetting;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected FonnteSetting $setting;

    public function __construct(?FonnteSetting $setting = null)
    {
        $this->setting = $setting ?? FonnteSetting::where('is_active', true)->first()
            ?? throw new \RuntimeException('No active Fonnte setting found in database.');
    }

    /**
     * Send a single message using FonnteMessageData DTO.
     *
     * @param FonnteMessageData $data
     * @return array{success: bool, request_id: string|null, detail: array<string, mixed>}
     * @throws FonnteApiException
     */
    public function sendMessage(FonnteMessageData $data): array
    {
        $payload = $data->toPayload();
        return $this->sendRequest($payload);
    }

    /**
     * Send bulk messages using an array of payload data.
     *
     * @param array<int, array<string, mixed>|FonnteMessageData> $payloadData
     * @return array{success: bool, request_id: string|null, detail: array<string, mixed>}
     * @throws FonnteApiException
     */
    public function sendBulkData(array $payloadData): array
    {
        $formattedData = [];

        foreach ($payloadData as $item) {
            if ($item instanceof FonnteMessageData) {
                $formattedData[] = $item->toPayload();
            } elseif (is_array($item)) {
                // Apply validation rules strictly
                $target = $item['target'] ?? '';
                if (is_array($target)) {
                    $target = implode(',', array_map('trim', $target));
                }
                $target = (string) $target;

                $delay = isset($item['delay']) ? (string) $item['delay'] : null;
                $countryCode = isset($item['countryCode']) ? (string) $item['countryCode'] : null;

                $formattedItem = [
                    'target' => $target,
                    'message' => (string) ($item['message'] ?? ''),
                ];

                if (isset($item['url'])) {
                    $formattedItem['url'] = (string) $item['url'];
                }
                if (isset($item['filename'])) {
                    $formattedItem['filename'] = (string) $item['filename'];
                }
                if (isset($item['schedule'])) {
                    $formattedItem['schedule'] = (int) $item['schedule'];
                }
                if ($delay !== null) {
                    $formattedItem['delay'] = $delay;
                }
                if (isset($item['typing'])) {
                    $formattedItem['typing'] = filter_var($item['typing'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
                }
                if ($countryCode !== null) {
                    $formattedItem['countryCode'] = $countryCode;
                }
                if (isset($item['preview'])) {
                    $formattedItem['preview'] = filter_var($item['preview'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
                }

                $formattedData[] = $formattedItem;
            }
        }

        $payload = [
            'data' => json_encode($formattedData),
        ];

        return $this->sendRequest($payload);
    }

    /**
     * Send the HTTP request to Fonnte API.
     *
     * @param array<string, mixed> $payload
     * @return array{success: bool, request_id: string|null, detail: array<string, mixed>}
     * @throws FonnteApiException
     */
    protected function sendRequest(array $payload): array
    {
        $url = rtrim($this->setting->base_url, '/') . '/send';

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->setting->token,
            ])
            ->timeout(15)
            ->retry(3, 100)
            ->asForm()
            ->post($url, $payload)
            ->throw();

            $responseBody = $response->json();

            // Parser khusus untuk membaca status Fonnte
            $status = $responseBody['status'] ?? false;

            if ($status === true) {
                $ids = $responseBody['id'] ?? [];
                $requestId = is_array($ids) ? ($ids[0] ?? null) : $ids;

                return [
                    'success' => true,
                    'request_id' => is_scalar($requestId) ? (string) $requestId : null,
                    'detail' => $responseBody,
                ];
            }

            $reason = $responseBody['reason'] ?? 'Unknown error response from Fonnte API';
            throw new FonnteApiException($reason, $response->status(), $responseBody ?? []);

        } catch (RequestException $e) {
            $responseBody = $e->response?->json() ?? [];
            $reason = $responseBody['reason'] ?? $e->getMessage();

            Log::error('Fonnte API HTTP Request Exception', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
            ]);

            throw new FonnteApiException(
                $reason,
                $e->response?->status() ?? 0,
                $responseBody,
                $e
            );
        } catch (\Exception $e) {
            if ($e instanceof FonnteApiException) {
                throw $e;
            }

            Log::error('Fonnte API General Exception', [
                'message' => $e->getMessage(),
            ]);

            throw new FonnteApiException(
                'An error occurred: ' . $e->getMessage(),
                0,
                [],
                $e
            );
        }
    }
}
