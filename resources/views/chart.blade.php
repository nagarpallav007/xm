<!-- resources/views/chart.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Stock Quotes Chart</h1>

        <h2>Company: {{ $companyName }}</h2>
        <h2>Date Range: {{ $startDate }} to {{ $endDate }}</h2>

        <canvas id="chart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const dates = {!! json_encode($dates) !!};
        const openPrices = {!! json_encode($openPrices) !!};
        const closePrices = {!! json_encode($closePrices) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: 'Open',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        data: openPrices,
                    },
                    {
                        label: 'Close',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        data: closePrices,
                    },
                ],
            },
            options: {},
        });
    </script>
@endsection
