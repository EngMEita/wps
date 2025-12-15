<?php

namespace Meita\Wps\Contracts;

class BankFile
{
    public function __construct(
        public readonly string $filename,
        public readonly string $content,
        public readonly string $mimeType = 'text/plain'
    ) {
    }
}
