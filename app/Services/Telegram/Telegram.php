<?php

namespace App\Services\Telegram;

use GuzzleHttp\Client;

class Telegram
{
    protected Client $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
