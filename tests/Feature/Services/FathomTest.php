<?php

declare(strict_types=1);

use App\Services\Fathom\Service;

it('can resolve the service from the container', function () {
    expect(
        app(Service::class)
    )->toBeInstanceOf(Service::class)->uri->toEqual(config('services.fathom.uri'));
});
