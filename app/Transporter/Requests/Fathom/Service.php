<?php

namespace App\Transporter\Requests\Fathom;

use App\Services\Fathom\Resources\SitesCollection;
use App\Services\Fathom\Resources\SiteValueObject;

class Service
{
    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function sites(): SitesCollection
    {
        $response = ListSites::build()->authenticate()->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        return new SitesCollection(
            items: $response->collect('data')->map(fn ($item) =>
                new SiteValueObject(
                    id: $item['id'],
                    object: $item['object'],
                    name: $item['name'],
                ),
            ),
        );
    }
}
