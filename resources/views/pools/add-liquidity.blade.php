@extends('layouts.app')

@section('title', 'Add Liquidity')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-coins me-2"></i> Add Liquidity to 
                    <span class="badge bg-info me-1">{{ $pool->tokenA->symbol }}</span> / 
                    <span class="badge bg-warning text-dark">{{ $pool->tokenB->symbol }}</span>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pools.addLiquidity.store', $pool) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ $pool->tokenA->symbol }} Amount</label>
                            <input type="number" step="any" name="amount_a" class="form-control form-control-lg" placeholder="0.0" required>
                        </div>
                        <div class="text-center my-3">
                            <i class="fas fa-plus text-secondary"></i>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ $pool->tokenB->symbol }} Amount</label>
                            <input type="number" step="any" name="amount_b" class="form-control form-control-lg" placeholder="0.0" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Liquidity</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection