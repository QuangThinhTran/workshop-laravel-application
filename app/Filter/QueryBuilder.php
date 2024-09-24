<?php

namespace App\Filter;

use Illuminate\Http\Request;

class QueryBuilder
{
    /**
     * @var Request
     * */
    public Request $request;

    /**
     * @var array
     * */
    protected array $filters = [];

    /**
     * @var $builder
     */
    protected $builder;

    /**
     * @var string
     * */
    protected string $sortBy = 'created_at';

    /**
     * @var string
     * */
    protected string $sortOrder = 'desc';

    /**
     * @var int
     * */
    protected int $perPage = 10;

    /**
     * @var int
     * */
    protected int $page = 1;

    public function apply($request, $filters, $sorts)
    {
        if (method_exists($this, 'filter')) {
            $this->builder = $this->filterable($this->builder, $filters, $sorts);
        }

        $this->paginate($this->builder);
    }

    /**
     * @param $query
     * @return mixed
     */
    private function paginate($query): mixed
    {
        return $query->limit($this->perPage)->offset(($this->page - 1) * $this->perPage);
    }
}
