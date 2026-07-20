@extends('layouts.app')

@section('title', __('Pools') . ' - Amin Finance')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-water text-accent me-2"></i>{{ __('Pools') }}</h2>
        <a href="{{ route('pools.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> {{ __('Create Pool') }}
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('pools.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                    style="height: 30px; font-size: 0.8rem;"
                    placeholder="{{ __('Search token...') }}"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center"
                    style="height: 30px; font-size: 1rem;">
                    {{ __('Search') }}
                </button>
                @if(request('search'))
                <a href="{{ route('pools.index') }}" class="btn btn-sm btn-outline-light ms-1 d-flex align-items-center justify-content-center">
                    <i class="fas fa-times"></i> {{ __('Clear') }}
                </a>
                @endif
            </form>
        </div>
    </div>
    <div class="row">
        @forelse($pools as $pool)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle p-2 me-2">
                            <i class="fas fa-coins text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-0">{{ $pool->tokenA->symbol }}/{{ $pool->tokenB->symbol }}</h5>
                    </div>
                    <div class="row text-secondary small">
                        <div class="col-6">{{ __('Reserve') }} {{ $pool->tokenA->symbol }}:</div>
                        <div class="col-6 text-end">{{ number_format($pool->reserve_a, 4) }}</div>
                        <div class="col-6">{{ __('Reserve') }} {{ $pool->tokenB->symbol }}:</div>
                        <div class="col-6 text-end">{{ number_format($pool->reserve_b, 4) }}</div>
                        <div class="col-6">{{ __('Fee') }}:</div>
                        <div class="col-6 text-end">{{ $pool->fee_percent }}%</div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('pools.show', $pool) }}" class="btn btn-outline-light btn-sm flex-grow-1">
                            {{ __('View Pool') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        <div class="like-widget"
                            data-pool-id="{{ $pool->id }}"
                            data-liked="{{ auth()->check() && $pool->isLikedBy(auth()->user()) ? 'true' : 'false' }}"
                            data-count="{{ $pool->likes_count ?? 0 }}"
                            style="min-width:56px; display:flex; align-items:center; justify-content:center;">
                            <noscript>
                                <form method="POST" action="{{ route('pools.like', $pool) }}">
                                    @csrf
                                    <button class="btn btn-outline-light btn-sm" type="submit">❤ {{ $pool->likes_count ?? 0 }}</button>
                                </form>
                            </noscript>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                    <h5>{{ __('No pools yet') }}</h5>
                    <p>{{ __('Create the first liquidity pool to get started.') }}</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $pools->links() }}
    </div>
</div>
@endsection