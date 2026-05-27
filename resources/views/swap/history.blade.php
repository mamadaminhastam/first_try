@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Transaction History</h1>
    <table class="table">
        <thead>
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
                <td>{{ $tx->tokenFrom->symbol }}</td>
                <td>{{ $tx->tokenTo->symbol }}</td>
                <td>{{ $tx->amount_from }}</td>
                <td>{{ $tx->amount_to }}</td>
                <td>{{ $tx->rate }}</td>
                <td>{{ $tx->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection