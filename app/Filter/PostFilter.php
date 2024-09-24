<?php

namespace App\Filter;

use App\Filter\QueryBuilder;

class PostFilter extends QueryBuilder
{
    public string $sortBy = 'id';

    public array $fillable = [
        'title',
        'content',
        'author',
    ];

    public function filterTitle($title)
    {
        return $this->builder->where('title', 'like', "%$title%");
    }

    public function filterContent($content)
    {
        return $this->builder->where('content', 'like', "%$content%");
    }

    public function filterAuthor($author)
    {
        return $this->builder->where('author', $author);
    }
}
