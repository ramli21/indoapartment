<?php

namespace App\Jobs;

use App\DTOs\FonnteMessageData;
use App\Services\FonnteService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappMessageJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public FonnteMessageData $messageData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(FonnteService $fonnteService): void
    {
        try {
            $result = $fonnteService->sendMessage($this->messageData);

            Log::info('WhatsApp message sent successfully via Queue Job', [
                'target' => $this->messageData->getFormattedTarget(),
                'request_id' => $result['request_id'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message via Queue Job', [
                'target' => $this->messageData->getFormattedTarget(),
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
