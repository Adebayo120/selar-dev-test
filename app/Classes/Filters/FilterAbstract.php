<?php

namespace App\Classes\Filters;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

abstract class FilterAbstract
{
    /**
     * Apply filter.
     *
     * @param  Builder $builder
     * @param  mixed  $value
     *
     * @return Builder
     */
    public abstract function filter(Builder $builder, $value);

    /**
     * Database value mappings.
     *
     * @return array
     */
    protected function mappings()
    {
        return [];
    }

    /**
     * Resolve the value used for filtering.
     *
     * @param  mixed $key
     * @return mixed
     */
    protected function resolveFilterValue($key)
    {
        return Arr::get($this->mappings(), $key);
    }

    /**
     * Resolve the order direction to be used.
     *
     * @param  string $direction
     * @return string
     */
    protected function resolveOrderDirection($direction)
    {
        return Arr::get([
            'desc' => 'desc',
            'asc' => 'asc'
        ], $direction, 'desc');
    }

    /**
     * resolveDateValue
     *
     * @param [type] $value
     * @return static|false
     */
    public function resolveDateValue ( $value )
    {
        return Carbon::parse($value)->setTimezone('UTC');
    }

}
