<?php

declare(strict_types=1);

namespace App\Services\Fathom\Resources;

class SiteValueObject
{
    /**
     * @param string $id
     * @param string $object
     * @param string $name
     */
    public function __construct(
        public string $id,
        public string $object,
        public string $name,
    ) {}
}
