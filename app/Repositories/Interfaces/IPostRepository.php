<?php

namespace App\Repositories\Interfaces;

interface IPostRepository
{
    public function getPostsByCondition(array $fields, array $conditions, int $limit, int $offset, $orderBy, bool $order);

    public function filter();
}
