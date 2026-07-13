@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Overview</h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-coins"
                title="Total Tokens"
                value="{{ \App\Models\Token::count() }}"
                color="primary"
                link="{{ route('admin.tokens.index') }}" />
        </div>
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-water"
                title="Liquidity Pools"
                value="{{ \App\Models\LiquidityPool::count() }}"
                color="success"
                link="{{ route('pools.index') }}" />
        </div>
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-exchange-alt"
                title="My Swaps"
                value="{{ \App\Models\Transaction::where('user_id', Auth::id())->count() }}"
                color="info"
                link="{{ route('swap.history') }}" />
        </div>
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-user"
                title="Profile"
                value="{{ Auth::user()->name }}"
                color="warning"
                link="#" />
        </div>
    </div>
</div>
@endsection