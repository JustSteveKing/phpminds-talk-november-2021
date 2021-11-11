<?php

declare(strict_types=1);

namespace App\Services\Fathom;

class Service
{
    public function __construct(
        public string $uri,
        public string $token,
        public int $timeout,
        public null|int $retryTimes = null,
        public null|int $retrySleep = null,
    ) {}
}
