<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class ReportAgent extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $chart = new ReportAgent;

        $chart->labels(['One', 'Two', 'Three']);

        $chart->dataset('My dataset 1', 'line', [1, 2, 3]);

        return view('pages.back-office-agent.index', compact('chart'));


    }

}
