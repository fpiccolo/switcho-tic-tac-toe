<?php
declare(strict_types=1);

namespace App\DTO\Output;

class ExceptionOutput
{
    public string $message;
    public int $code;

    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
    }
}