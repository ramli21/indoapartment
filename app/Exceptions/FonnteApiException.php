<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class FonnteApiException extends Exception
{
    /**
     * @var array<string, mixed>
     */
    protected array $responseBody;

    /**
     * @param array<string, mixed> $responseBody
     */
    public function __construct(string $message, int $code = 0, array $responseBody = [], ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->responseBody = $responseBody;
    }

    /**
     * Get the full API response body if available.
     *
     * @return array<string, mixed>
     */
    public function getResponseBody(): array
    {
        return $this->responseBody;
    }
}
