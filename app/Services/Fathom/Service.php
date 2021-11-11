<?php

declare(strict_types=1);

namespace App\Services\Fathom;

use App\Services\Fathom\Resources\SitesCollection;
use App\Services\Fathom\Resources\SiteValueObject;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Service
{
    /**
     * @param string $uri
     * @param string $token
     * @param int $timeout
     * @param int|null $retryTimes
     * @param int|null $retrySleep
     */
    public function __construct(
        public string $uri,
        public string $token,
        public int $timeout,
        public null|int $retryTimes = null,
        public null|int $retrySleep = null,
    ) {}

    /**
     * @return PendingRequest
     */
    public function makeRequest(): PendingRequest
    {
        $request = Http::baseUrl(
            url: $this->uri,
        )->withToken(
            token: $this->token,
        )->timeout(
            seconds: $this->timeout,
        );

        if (! is_null($this->retryTimes) && ! is_null($this->retrySleep)) {
            $request->retry(
                times: $this->retryTimes,
                sleep: $this->retrySleep,
            );
        }

        return $request;
    }

    /**
     * @return SitesCollection
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function sites(): SitesCollection
    {
        $request = $this->makeRequest();

        $response = $request->get(
            url: '/sites',
        );

        if ($response->failed()) {
            throw $response->toException();
        }

        return new SitesCollection(
            items: $response->collect('data')->map(fn($item) =>
                new SiteValueObject(
                    id: $item['id'],
                    object: $item['object'],
                    name: $item['name'],
                ),
            ),
        );
    }

    /**
     * @param string $id
     * @return SiteValueObject
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function site(string $id): SiteValueObject
    {
        $request = $this->makeRequest();

        $response = $request->get(
            url: "/sites/{$id}",
        );

        if ($response->failed()) {
            throw $response->toException();
        }

        return new SiteValueObject(
            id: $response->json('id'),
            object: $response->json('object'),
            name: $response->json('name'),
        );
    }

    /**
     * @param array $attributes
     * @return SiteValueObject
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createSite(array $attributes): SiteValueObject
    {
        Validator::make(
            data: $attributes,
            rules: [
                'name' => [
                    'required',
                    'string',
                ],
                'sharing' => [
                    'nullable',
                    'string',
                    'in:none,private,public'
                ],
                'share_password' => [
                    'nullable',
                    'string',
                ],
            ],
        )->validate();

        $request = $this->makeRequest();

        $response = $request->post(
            url: '/sites',
            data: $attributes,
        );

        if ($response->failed()) {
            throw $response->toException();
        }

        return new SiteValueObject(
            id: $response->json('id'),
            object: $response->json('object'),
            name: $response->json('name'),
        );
    }
}
