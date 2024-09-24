<?php

namespace App\Services\Webhook;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ProductWebhook extends WebhookBase
{
    protected string $path = 'products';

    /**
     * Get products from the Shopify API
     * @return array
     * */
    public function getProducts(): array
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        $request = new Request(
            'GET',
            $this->getEndPoint(),
            $headers
        );

        try {
            $response = $this->client->send($request);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            return ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ['error' => 'An unexpected error occurred.'];
        }
    }

    /**
     * Create a product in the Shopify API
     * @param array $data
     * @return array
     * */
    public function createProduct(array $data): array
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        $httpBody = json_encode($data);

        $request = new Request(
            'POST',
            $this->getEndPoint(),
            $headers,
            $httpBody
        );

        try {
            $response = $this->client->send($request);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            return ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ['error' => 'An unexpected error occurred.'];
        }
    }
}
