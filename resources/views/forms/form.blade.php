@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Stock Quotes Form</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="symbol" class="form-label">Company Symbol:</label>
                <select id="symbol" name="symbol" class="form-select @error('symbol') is-invalid @enderror">
                    <option value="">Select a symbol</option>
                    @foreach ($symbols as $symbol)
                        <option value="{{ $symbol }}" {{ old('symbol') == $symbol ? 'selected' : '' }}>
                            {{ $symbol }}
                        </option>
                    @endforeach
                </select>
                @error('symbol')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="text" id="start_date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="text" id="end_date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        $(function() {
            // Initialize Select2 for symbol field
            $('#symbol').select2({
                placeholder: 'Select a symbol',
                allowClear: true,
            });

            // Initialize jQuery UI datepicker for start_date and end_date fields
            var today = new Date();
            $('#start_date').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: today,
                onSelect: function(selectedDate) {
                    $('#end_date').datepicker('option', 'minDate', selectedDate);
                }
            });

            $('#end_date').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: today,
                onSelect: function(selectedDate) {
                    $('#start_date').datepicker('option', 'maxDate', selectedDate);
                }
            });
        });
    </script>
@endsection
