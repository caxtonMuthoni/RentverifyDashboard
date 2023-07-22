<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class DefaultersChart extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'line';

    // protected $lineOptions = [
    //     'spline' => 1,
    //     'regionFill' => 1,
    //     'hideDots' => 0,
    //     'hideLine' => 0,
    //     'heatline' => 0,
    //     'dotSize' => 3,
    // ];

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
