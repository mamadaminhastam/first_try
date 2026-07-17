@extends('layouts.app')

@section('title', 'Swap - Amin Finance')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="swap-card" style="max-width: 440px; width: 100%;">
        <div class="card">
            <div class="card-header px-3 py-2">
                <h5 class="mb-0"><i class="fas fa-exchange-alt me-1"></i> Swap</h5>
            </div>
            <div class="card-body p-3">
                @if(session('success'))
                <div class="alert alert-success py-1 px-2 small mb-2">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger py-1 px-2 small mb-2">{{ session('error') }}</div>
                @endif
                <form action="{{ route('swap.perform') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small mb-1">From</label>
                        <div id="token-from" class="searchable-select" data-tokens='@json($tokens)'>
                            <input type="text" class="form-control search-input" placeholder="Search token..." autocomplete="off">
                            <input type="hidden" name="token_from">
                            <div class="options d-none"></div>
                        </div>
                    </div>
                    <div class="text-center my-1">
                        <i class="fas fa-arrow-down text-secondary"></i>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small mb-1">To</label>
                        <div id="token-to" class="searchable-select" data-tokens='@json($tokens)'>
                            <input type="text" class="form-control search-input" placeholder="Search token..." autocomplete="off">
                            <input type="hidden" name="token_to">
                            <div class="options d-none"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small mb-1">Amount</label>
                        <div class="input-group input-group-sm">
                            <input type="text" inputmode="decimal" pattern="[0-9]*[.,]?[0-9]*" name="amount" class="form-control amount-input" placeholder="0.0" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Swap</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection