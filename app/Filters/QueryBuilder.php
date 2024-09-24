<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QueryBuilder
{
    /**
     * @var Request
     * */
    public Request $request;

    /**
     * @var array
     * */
    protected array $filters;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @var array|null The list of filterable fields.
     */
    protected ?array $filterable;

    /**
     * @var int The current page number for pagination.
     */
    protected int $currentPage = 0;

    /**
     * @var int The current page size for pagination.
     */
    protected int $currentPageSize = 10;

    /**
     * @var string The current sorting column.
     */
    protected string $currentSort = 'created_at';

    /**
     * @var string The current sorting type ('asc' or 'desc').
     */
    protected string $currentSortType = 'desc';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->filters = $this->request->all();
    }

    protected function getPage(): int
    {
        return $this->filters['page'] ?? $this->currentPage;
    }

    protected function getPageSize(): int
    {
        return $this->filters['page_size'] ?? $this->currentPageSize;
    }

    protected function getSort(): string
    {
        return $this->filters['sort'] ?? $this->currentSort;
    }

    protected function getSortType(): string
    {
        return $this->filters['sort_type'] ?? $this->currentSortType;
    }

    protected function getTotal(): int
    {
        return count($this->builder->get());
    }

    /**
     * Apply filters, sorting, and pagination to the query builder.
     * @param Builder $builder
     * @return array
     */
    public function apply(Builder $builder): array
    {
        $this->builder = $builder;

        $this->applyFilters();
        $this->applySort();
        $this->applyPagination();

        return [
            'result' => $this->builder->get(),
            'total' => $this->getTotal(),
            'page' => $this->getPage(),
            'page_size' => $this->getPageSize(),
        ];
    }

    private function applyFilters()
    {
        foreach ($this->filters as $key => $value) {
            $method = 'filter' . Str::studly($key);
            if ($value !== '' && method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }

    /**
     * Apply pagination to the query builder.
     * @return void
     */
    private function applyPagination(): void
    {
        $page = $this->getPage();
        $pageSize = $this->getPageSize();
        $this->builder->skip(($page - 1) * $pageSize)->take($pageSize);
    }

    /**
     * Apply sorting to the query builder.
     * @return void
     */
    private function applySort(): void
    {
        $sort = $this->getSort();
        $sortType = $this->getSortType();
        $this->builder->orderBy($sort, strtoupper($sortType));
    }
}
