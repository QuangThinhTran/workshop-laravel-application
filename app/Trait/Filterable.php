<?php

namespace App\Trait;

use App\Filters\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilterable(Builder $builder, QueryBuilder $queryBuilder): array
    {
        return $queryBuilder->apply($builder);
    }
}
