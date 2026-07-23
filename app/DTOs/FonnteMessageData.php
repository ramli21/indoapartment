<?php

namespace App\DTOs;

use InvalidArgumentException;

readonly class FonnteMessageData
{
    /**
     * @param string|array<int, string> $target
     */
    public function __construct(
        public string|array $target,
        public string $message,
        public ?string $url = null,
        public ?string $filename = null,
        public ?int $schedule = null,
        public ?string $delay = null,
        public ?bool $typing = null,
        public ?string $countryCode = null,
        public ?bool $preview = null,
    ) {
        if (empty($this->target)) {
            throw new InvalidArgumentException('Target cannot be empty.');
        }
        if (empty($this->message)) {
            throw new InvalidArgumentException('Message cannot be empty.');
        }
    }

    /**
     * Get the target formatted as a comma-separated string.
     */
    public function getFormattedTarget(): string
    {
        if (is_array($this->target)) {
            return implode(',', array_map('trim', $this->target));
        }

        return trim($this->target);
    }

    /**
     * Convert the DTO to Fonnte API payload structure.
     *
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        $payload = [
            'target' => $this->getFormattedTarget(),
            'message' => $this->message,
        ];

        if ($this->url !== null) {
            $payload['url'] = $this->url;
        }

        if ($this->filename !== null) {
            $payload['filename'] = $this->filename;
        }

        if ($this->schedule !== null) {
            $payload['schedule'] = $this->schedule;
        }

        if ($this->delay !== null) {
            $payload['delay'] = (string) $this->delay;
        }

        if ($this->typing !== null) {
            $payload['typing'] = $this->typing ? 'true' : 'false';
        }

        if ($this->countryCode !== null) {
            $payload['countryCode'] = (string) $this->countryCode;
        }

        if ($this->preview !== null) {
            $payload['preview'] = $this->preview ? 'true' : 'false';
        }

        return $payload;
    }
}
