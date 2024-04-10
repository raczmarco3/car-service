<?php

namespace App\Exceptions;

class RequestException extends \Exception
{
    private $meta;

    public function __construct($meta)
    {
        $this->meta = $meta;
        parent::__construct();
    }

    public function getResponse(): array
    {
        return $this->meta;
    }
}
