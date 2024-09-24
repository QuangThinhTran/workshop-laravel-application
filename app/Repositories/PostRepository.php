<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\IPostRepository;

class PostRepository implements IPostRepository
{
    /**
     * Get posts by conditions
     * @param array $fields
     * @param array $conditions
     * @param string $orderBy
     * @param bool $order
     * @param int $limit
     * @param int $offset
     * @return mixed
     * */
    public function getPostsByCondition(array $fields = ['*'], array $conditions = [], int $limit = 10, int $offset = 0, $orderBy = 'created_at', bool $order = true): mixed
    {
        $query = Post::select($fields);

        if (!empty($conditions)) {
            $query->where($conditions);
        }

        $query->orderBy($orderBy, $order ? 'desc' : 'asc');

        $query->limit($limit ?: 10)->offset($offset ?: 0);
        return $query;
    }

    public function filter()
    {

    }
}
