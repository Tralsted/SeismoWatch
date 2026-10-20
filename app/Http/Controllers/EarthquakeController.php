<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EarthquakeController extends Controller {

    public function index(\Illuminate\Http\Request $request) {
        $request->validate([
            'min_magnitude' => ['nullable', 'numeric', 'min:2.5'],
        ]);

        $filter = $request->query('filter', 'today');
        $magfilter = $request->query('min_magnitude');

        $query = Earthquake::query();

        if ($filter === 'today'){
            $query->whereDate('occured_at', Carbon::today());
        }

        if ($magfilter){
            $query->where('magnitude', '>=', $magfilter);
        }

        $limit = ($filter === 'all') ? 200 : 15;

        $earthquakes = $query->latest('occured_at')
            ->take($limit)
            ->get()
            ->reverse();

        $labels = $earthquakes->pluck('occured_at')->map(function($date) {
            return $date->format('H:i');
        });

        $magnitudes = $earthquakes->pluck('magnitude');
        $avgMag = $magnitudes->avg() ?? 0;

        // to display the earthquake with the max magnitude
        $maxQuake = $earthquakes->sortByDesc('magnitude')->first();

        // to display specific location on data point
        $locations = $earthquakes->pluck('location');

        return view('index', compact(
            'labels',
            'magnitudes',
            'earthquakes',
            'maxQuake',
            'filter',
            'avgMag',
            'magfilter',
            'locations'
        ));
    }
}
