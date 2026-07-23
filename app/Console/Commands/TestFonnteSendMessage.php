<?php

namespace App\Console\Commands;

use App\DTOs\FonnteMessageData;
use App\Jobs\SendWhatsappMessageJob;
use App\Services\FonnteService;
use App\Exceptions\FonnteApiException;
use Illuminate\Console\Command;

class TestFonnteSendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fonnte:send 
                            {target : The destination number(s) or comma separated list} 
                            {message : The text message to send} 
                            {--queue : Send asynchronously using Laravel queues}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test WhatsApp message using Fonnte API';

    /**
     * Execute the console command.
     */
    public function handle(FonnteService $fonnteService): int
    {
        $target = $this->argument('target');
        $message = $this->argument('message');
        $useQueue = $this->option('queue');

        $this->info("Preparing to send message to: {$target}");

        try {
            // Instantiate DTO
            $messageData = new FonnteMessageData(
                target: $target,
                message: $message,
                delay: '2', // default delay to respect guidelines
                countryCode: '62'
            );

            if ($useQueue) {
                $this->info("Dispatching SendWhatsappMessageJob to the queue...");
                SendWhatsappMessageJob::dispatch($messageData);
                $this->success("Job successfully dispatched!");
                return self::SUCCESS;
            }

            $this->info("Sending direct HTTP request via FonnteService...");
            $response = $fonnteService->sendMessage($messageData);

            $this->info("Message sent successfully!");
            $this->line("Request ID: " . ($response['request_id'] ?? 'N/A'));
            $this->line("Detail: " . json_encode($response['detail'], JSON_PRETTY_PRINT));

            return self::SUCCESS;
        } catch (FonnteApiException $e) {
            $this->error("Fonnte API Exception: " . $e->getMessage());
            $this->line("Response Code: " . $e->getCode());
            $this->line("Response Body: " . json_encode($e->getResponseBody(), JSON_PRETTY_PRINT));
            return self::FAILURE;
        } catch (\Exception $e) {
            $this->error("General Error: " . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Output a success message.
     */
    protected function success(string $message): void
    {
        $this->line("<info>[SUCCESS]</info> {$message}");
    }
}
