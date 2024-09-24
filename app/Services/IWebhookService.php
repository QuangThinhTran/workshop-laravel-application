<?php

namespace App\Services;

interface IWebhookService
{
    public function getProducts();

    public function createProduct($data);
}
