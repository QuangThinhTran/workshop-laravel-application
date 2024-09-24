<?php

namespace App\Services;

use App\Services\Webhook\ProductWebhook;

class WebhookService implements IWebhookService
{
    /**
     * Get products from the Shopify API
     * @return array
     * */
    public function getProducts(): array
    {
        $products = new ProductWebhook();
        return $products->getProducts();
    }

    public function createProduct($data): array
    {
        $product = new ProductWebhook();
        return $product->createProduct($data);
    }
}
