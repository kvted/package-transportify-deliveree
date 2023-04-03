<?php

namespace MsysCorp\TransportifyDeliveree\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class InvalidArgumentException extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    #[Pure] public function __construct(string $message = "Invalid format.", int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}