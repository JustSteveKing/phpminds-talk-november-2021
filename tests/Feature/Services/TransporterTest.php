<?php

use App\Services\Fathom\Resources\SitesCollection;
use App\Transporter\Requests\Fathom\FetchSite;
use App\Transporter\Requests\Fathom\ListSites;
use App\Transporter\Requests\Fathom\Service;
use Illuminate\Http\Client\Response;
use JustSteveKing\StatusCode\Http;

it('can get a list of sites', function () {
    expect(ListSites::build()->authenticate()->send())
        ->toBeInstanceOf(Response::class);
});

it('can get a single site', function () {
    expect(
        FetchSite::build()->authenticate()->setPath(
            path: "/sites/SGJKEWOR",
        )->send(),
    )->toBeInstanceOf(Response::class);
});

it('can get a list of sites using a transporter service', function () {
    expect(
        Service::sites(),
    )->toBeInstanceOf(SitesCollection::class);
});

it('can mock a request', function () {
   dd(FetchSite::fake()->withFakeData([
       'test' => 'test'
   ])->authenticate()->setPath(
       path: "/sites/SGJKEWOR",
   )->send()->json());
});
