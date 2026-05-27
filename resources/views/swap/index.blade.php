@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Swap Tokens</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('swap.perform') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>From Token</label>
            <select name="token_from" class="form-control">
                @foreach($tokens as $token)
                    <option value="{{ $token->id }}">{{ $token->symbol }} ({{ $token->name }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>To Token</label>
            <select name="token_to" class="form-control">
                @foreach($tokens as $token)
                    <option value="{{ $token->id }}">{{ $token->symbol }} ({{ $token->name }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="any" name="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Swap</button>
    </form>
</div>
@endsection