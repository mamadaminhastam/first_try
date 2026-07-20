@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="container">
    <h2 class="mb-4">{{ __('Dashboard Overview') }}</h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-coins"
                title="{{ __('Total Tokens') }}"
                value="{{ \App\Models\Token::count() }}"
                color="primary"
                link="{{ route('admin.tokens.index') }}" />
        </div>
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-water"
                title="{{ __('Liquidity Pools') }}"
                value="{{ \App\Models\LiquidityPool::count() }}"
                color="success"
                link="{{ route('pools.index') }}" />
        </div>
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-exchange-alt"
                title="{{ __('My Swaps') }}"
                value="{{ \App\Models\Transaction::where('user_id', Auth::id())->count() }}"
                color="info"
                link="{{ route('swap.history') }}" />
        </div>
        <div class="col-md-3 mb-3">
            <x-card-box
                icon="fas fa-user"
                title="{{ __('Profile') }}"
                value="{{ Auth::user()->name }}"
                color="warning"
                link="{{ route('profile.show') }}" />
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('My Token Balances') }}</div>
                <div class="card-body">
                    @php
                    $balances = \App\Models\UserBalance::where('user_id', Auth::id())
                    ->where('balance', '>', 0)
                    ->with('token')
                    ->get();
                    @endphp

                    @if($balances->isEmpty())
                    <p class="text-secondary">{{ __('You have no tokens.') }}</p>
                    @else
                    <div class="list-group">
                        @foreach($balances as $b)
                        <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            <div>
                                <strong>{{ $b->token->symbol }}</strong>
                                <div class="text-secondary small">{{ $b->token->name }}</div>
                            </div>
                            <div class="fw-bold">{{ number_format($b->balance, 6) }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection