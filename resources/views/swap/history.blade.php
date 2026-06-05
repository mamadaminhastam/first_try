@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📜 Transaction History</h1>

    @if($transactions->isEmpty())
        <div class="alert alert-info">No transactions yet. Go <a href="{{ route('swap.index') }}">swap some tokens</a>!</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount From</th>
                        <th>Amount To</th>
                        <th>Rate</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $tx->tokenFrom->symbol }}</span></td>
                        <td><span class="badge bg-success">{{ $tx->tokenTo->symbol }}</span></td>
                        <td>{{ $tx->amount_from }}</td>
                        <td>{{ $tx->amount_to }}</td>
                        <td>{{ $tx->rate }}</td>
                        <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection