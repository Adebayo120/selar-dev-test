<?php

namespace App\Classes\Filters\User;

use App\Classes\Filters\IntervalFilter;
use App\Classes\Filters\{CurrencyFilter, FiltersAbstract, PlanFilter, DateFilter, };

class UserFilters extends FiltersAbstract
{
    /**
     * Default course filters.
     *
     * @var array
     */
    protected $filters = [
        "plan"      =>  PlanFilter::class,
        "currency"  =>  CurrencyFilter::class,
        "date"      =>  DateFilter::class,
        "interval"  =>  IntervalFilter::class
    ];
}
