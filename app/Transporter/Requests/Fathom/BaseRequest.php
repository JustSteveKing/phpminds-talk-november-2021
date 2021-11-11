<?php

declare(strict_types=1);

namespace App\Transporter\Requests\Fathom;

use JustSteveKing\Transporter\Request;

class BaseRequest extends Request
{
    protected string $method = 'GET';
    protected string $baseUrl = 'https://api.usefathom.com/v1';

    /**
     * @return $this
     */
    public function authenticate(): static
    {
        $this->request->withToken(
            token: config('services.fathom.token'),
        );

        return $this;
    }
}
