<?php

declare(strict_types=1);

use App\Services\Fathom\Resources\SitesCollection;
use App\Services\Fathom\Resources\SiteValueObject;
use App\Services\Fathom\Service;
use Illuminate\Http\Client\PendingRequest;

beforeEach(fn() => $this->service = app(Service::class));

it('can resolve the service from the container', function () {
    expect(
        $this->service
    )->toBeInstanceOf(Service::class)->uri->toEqual(config('services.fathom.uri'));
});

it('can create a new pending request to build and send', function () {
    expect(
        $this->service->makeRequest()
    )->toBeInstanceOf(PendingRequest::class);
});

it('can get a list of sites', function () {
    expect(
        $this->service->sites(),
    )->toBeInstanceOf(SitesCollection::class);
});

it('can get a single site', function () {
    expect($this->service->site(
        id: 'SGJKEWOR',
    ))->toBeInstanceOf(SiteValueObject::class)->id->toEqual('SGJKEWOR');
});

it('can create a new site', function () {
    $data = [
        'name' => 'Test Site for PHP MINDS',
    ];

    expect(
        $this->service->createSite(
            attributes: $data,
        )
    )->toBeInstanceOf(SiteValueObject::class)->name->toEqual($data['name']);

});
