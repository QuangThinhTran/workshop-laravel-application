<?php

namespace App\Filters;

use App\Filters\QueryBuilder;

class PostFilter extends QueryBuilder
{
    protected ?array $filterable = [
        'title',
        'content',
        'author',
    ];

//    public function filterTitle(?string $title)
//    {
//        return $this->builder->where('title', 'like', "%$title%");
//    }
//
//    public function filterContent(?string $content)
//    {
//        return $this->builder->where('content', 'like', "%$content%");
//    }

    public function filterAuthor($author)
    {
        return $this->builder->where('author', $author);
    }
}
