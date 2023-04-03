<?php

namespace MsysCorp\TransportifyDeliveree\Exception;

use Exception;

class BadRequestException extends Exception
{
    protected array $response;

    /**
     * @param array $response
     */
    public function setResponse(array $response): void
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }
}
