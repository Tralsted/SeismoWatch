<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SeismoWatch</title>
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/graph.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-5 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

        <!-- Dataset Today or All time -->
        <div class="flex gap-6 mb-2 ml-1">
            <a href="{{ route('index', ['filter' => 'today']) }}"
                class="text-xs uppercase tracking-widest font-bold transition-colors {{ $filter === 'today' ? 'text-lime-500' : 'text-gray-500 hover:text-white' }}">
                Today
            </a>
            <a href="{{ route('index', ['filter' => 'all']) }}"
                class="text-xs uppercase tracking-widest font-bold transition-colors {{ $filter === 'all' ? 'text-lime-500' : 'text-gray-500 hover:text-white' }}">
                All Time
            </a>
        </div>

        <!-- title -->
        <div class="absolute top-0 left-8">
            <<h1 class="text-2xl font-black tracking-tighter uppercase text-lime-500">
            Seismo<span class="text-white">Watch</span>
            </h1>
        </div>

        <!-- Display Highest Magnitude Window -->
        @php
            // changes the colour based on magnitude
            $mag = $maxQuake->magnitude ?? 0;

            if ($mag < 5.5){
                $colorClass = 'text-white';
            } elseif ($mag <= 6.9) {
                $colorClass = 'text-yellow-400';
            }
             else {
                $colorClass = 'text-red-500';
            }
        @endphp

        <div class="max-w-4xl w-full mx-auto mt-16 flex flex-col gap-4">
            <div class="bg-[#1a1a1a] border border-white/10 p-6 rounded-2xl shadow-xl flex items-center">

                <!-- Magnitude Filter -->
                <form action="/" method="GET" class="flex items-end gap-4 mb-6">
                    <input type="hidden" name="filter" value="{{ $filter }}">

                        <div class="flex flex-col">
                            <label for="min_mag" class="text-sm font-semibold text-gray-100">Magnitude Filter</label>
                            <input
                                type="number"
                                id="min_mag"
                                name="min_magnitude"
                                min="2.5"
                                step="0.1"
                                value="{{ $magfilter }}"
                                placeholder="default 2.5 (lower limit)"
                                class="mt-1 block w-full rounded-md border border-gray-600 bg-[#0a0a0a] text-white placeholder-gray-400 "
                                onchange="this.form.submit()"
                            >
                        </div>
                </form>

                <div class="flex items-center gap-6 ml-auto">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 font-bold">Highest Magnitude</p>
                        <h2 class="text-lg text-gray-100" id="max-location">  {{ $maxQuake->location ?? 'No data' }}</h2>
                    </div>
                    <div>
                        <span id="max-magnitude" class="text-4xl font-black text-red-500 tabular-nums {{ $colorClass }}">
                            {{ number_format($maxQuake->magnitude ?? 0, 1 )}}
                        </span>
                        <p class="text-[10px] text-gray-500 uppercase">Magnitude</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- main window for graph -->
        <div class ="window w-full max-w-4xl bg-white dark:bg-[#161616] p-6 rounded-lg shadow-xl">
            <div class="flex justify-between items-baseline mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400">
                        Seismic Activity <span class="text-[10px] opacity-50 ml-2">(UTC+0)</span>
                    </h3>

                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-medium">
                        Avg Magnitude • {{ number_format($avgMag, 1) }}
                    </p>
                </div>


            <div class="window-inner relative h-[400px] w-full">
                <canvas id="chart"
                        data-labels='{{ json_encode($labels) }}'
                        data-magnitudes='{{ json_encode($magnitudes) }}'
                        data-locations='{{ json_encode($locations) }}'
                        data-filter="{{ $filter }}">
                </canvas>
            </div>
        </div>
    </body>
</html>
