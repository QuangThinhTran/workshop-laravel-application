<?php

namespace App\Services\Webhook;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class WebhookBase
{
    protected ClientInterface $client;
    protected string $host;
    protected string $version;
    protected string $path;

    public function __construct()
    {
        $this->client = new Client();
        $this->initialize();
    }

    /**
     * Initialize the webhook
     * @return void
     * */
    protected function initialize(): void
    {
        $this->host = config('services.webhook.host');
        $this->version = config('services.webhook.version');
        $this->path = config('services.webhook.path');
    }

    /**
     * Get the host
     * @return string
     * */
    private function getHost(): string
    {
        return $this->host;
    }

    /**
     * Get the version
     * @return string
     * */
    private function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get the endpoint
     * @return string
     * */
    public function getEndPoint(): string
    {
        return 'https://' . $this->getHost() . '/admin/api/' . $this->getVersion() . '/' . $this->path;
    }
}
