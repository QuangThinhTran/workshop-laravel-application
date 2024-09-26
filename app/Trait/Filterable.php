<?php

namespace App\Trait;

use App\Filters\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filter the query
     * @param Builder $builder
     * @param QueryBuilder $queryBuilder
     * @return array
     * */
    public function scopeFilterable(Builder $builder, QueryBuilder $queryBuilder): array
    {
        return $queryBuilder->apply($builder);
    }
}
