@extends('base')

@include('navbar')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="table-heading mb-0 mt-3">Log History</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Timestamp</th>
                    <th class="text-center">Log Entry</th>
                </tr>
            </thead>
            <tbody>
                @if ($logEntries->isEmpty())
                    <tr>
                        <td colspan="2">No log entries found.</td>
                    </tr>
                @else
                    @foreach ($logEntries as $logEntry)
                        <tr>
                            <td class="text-center">{{ $logEntry->formattedCreatedAt }}</td>
                            <td class="text-center">{{ $logEntry->log_entry }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
