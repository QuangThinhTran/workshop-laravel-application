<?php
namespace App\Trait;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilterable(Builder $builder, array $filterFields = ['*'], array $sortFields = [])
    {
        return ;
    }
}
