<?php

declare(strict_types=1);

use App\Services\Fathom\Service;

it('can create a new fathom service', function (string $token) {
    expect(
        new Service(
            uri: 'https://api.test.com',
            token: $token,
            timeout: 10,
            retryTimes: 3,
            retrySleep: 1,
        ),
    )->toBeInstanceOf(Service::class)->token->toEqual($token);
})->with('tokens');

