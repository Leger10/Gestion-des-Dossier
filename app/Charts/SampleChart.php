<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class SampleChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $data = collect([]); // Could also be an array

        for ($days_backwards = 2; $days_backwards >= 0; $days_backwards--) {
            // Could also be an array_push if using an array rather than a collection.
            $data->push(Agent::whereDate('created_at', today()->subDays($days_backwards))->count());
        }

        $chart = new SampleChart;
        $chart->labels(['2 days ago', 'Yesterday', 'Today']);
        $chart->dataset('My dataset', 'line', $data);

        // return view('pages.back-office-agent.index', compact('chart'));


        // $chart = new SampleChart;
        // $chart->labels(['One', 'Two', 'Three', 'Four']);
        // $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
        // $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);

        // $today_users = Agent::whereDate('created_at', today())->count();
        // $yesterday_users = Agent::whereDate('created_at', today()->subDays(1))->count();
        // $users_2_days_ago = Agent::whereDate('created_at', today()->subDays(2))->count();

    }
}
