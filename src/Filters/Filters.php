<?php

namespace DanJamesMills\LaravelDropzone\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new ThreadFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        $this->mergeQuery();

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }

    /**
     * Return request object.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function mergeQuery()
    {
        if (isset($this->request->query()['query'])) {
            $this->request->merge($this->request->query()['query']);
        }
    }
}
