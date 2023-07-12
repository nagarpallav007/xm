@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Stock Quotes Result</h1>

        <h2>{{ $symbol }} Historical Quotes</h2>

        <table id="quotesTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Open</th>
                    <th>High</th>
                    <th>Low</th>
                    <th>Close</th>
                    <th>Volume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotes as $quote)
                    <tr>
                        <td>{{ $quote['date'] }}</td>
                        <td>{{ $quote['open'] }}</td>
                        <td>{{ $quote['high'] }}</td>
                        <td>{{ $quote['low'] }}</td>
                        <td>{{ $quote['close'] }}</td>
                        <td>{{ $quote['volume'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-4">
            <h2>Chart of Open and Close Prices</h2>
            <canvas id="chart"></canvas>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
        $(function() {
            var quotes = @json($quotes);

            var dates = quotes.map(function(quote) {
                return quote.date;
            });

            var openPrices = quotes.map(function(quote) {
                return quote.open;
            });

            var closePrices = quotes.map(function(quote) {
                return quote.close;
            });

            var ctx = document.getElementById('chart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Open',
                        data: openPrices,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false
                    }, {
                        label: 'Close',
                        data: closePrices,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: false
                    }]
                },
                options: {}
            });

            $('#quotesTable').DataTable();
        });
    </script>
@endsection
