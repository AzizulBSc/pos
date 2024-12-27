<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // function to show dashboard page
    public function index()
    {
        // Get all payments
        $data['total_student'] = 123;
        $data['total_estimated_collection'] = 123123;
        $data['total_collection'] = 123123;
        $data['total_due'] = 123123;

        // Get the current year
        $currentYear = now()->year;

        // Generate all months of the current year
        $months = collect(range(1, 12))->map(fn($month) => sprintf('%d-%02d', $currentYear, $month));

        // Generate fake data for each month
        $monthlyCollections = $months->mapWithKeys(function ($month) {
            return [
                $month => [
                    'month' => $month,
                    'total' => fake()->randomFloat(2, 1000, 5000), // Total amount (example: between 1000 and 5000)
                    'count' => fake()->numberBetween(1, 100),      // Count of payments (example: between 1 and 100)
                ],
            ];
        });

        // Convert to collection
        $monthlyCollections = collect($monthlyCollections);

        $areaChartIsBlank = true;
        $message = '';
        // Prepare the data for the chart
        $chartData = $months->mapWithKeys(function ($month) use ($monthlyCollections, &$areaChartIsBlank) {
            $collectedAmount = $monthlyCollections->get($month)['collected_amount'] ?? 0;

            if ($collectedAmount > 0) {
                $areaChartIsBlank = false;
            }

            return [
                $month => [
                    'month' => $month,
                    'collected_amount' => $collectedAmount,
                ]
            ];
        });

        $amounts = $chartData->pluck('collected_amount');
        if ($areaChartIsBlank) {
            $message = 'No data available';
        }
        return view('admin.dashboard', compact('data', 'amounts', 'message'));
    }
}
