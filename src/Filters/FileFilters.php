<?php

namespace DanJamesMills\LaravelDropzone\Filters;

class FileFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search'];

    protected function search($term)
    {
        $this->builder->where('original_filename', 'LIKE', '%'.$term.'%')
            ->orWhere('file_extension', 'LIKE', '%'.$term.'%');

        return $this->builder;
    }
}
