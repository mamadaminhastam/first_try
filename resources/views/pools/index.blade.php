@extends('layouts.app')

@section('title', 'Liquidity Pools')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-water text-accent me-2"></i>Liquidity Pools</h2>
        <a href="{{ route('pools.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create Pool
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                        <div class="col-6">Reserve {{ $pool->tokenA->symbol }}:</div>
                        <div class="col-6 text-end">{{ number_format($pool->reserve_a, 4) }}</div>
                        <div class="col-6">Reserve {{ $pool->tokenB->symbol }}:</div>
                        <div class="col-6 text-end">{{ number_format($pool->reserve_b, 4) }}</div>
                        <div class="col-6">Fee:</div>
                        <div class="col-6 text-end">{{ $pool->fee_percent }}%</div>
                    </div>
                    <a href="{{ route('pools.show', $pool) }}" class="btn btn-outline-light btn-sm mt-3 w-100">
                        View Pool <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                    <h5>No pools yet</h5>
                    <p>Create the first liquidity pool to get started.</p>
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