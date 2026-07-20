@extends('layouts.app')

@section('title', __('Swap') . ' - Amin Finance')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="swap-card" style="max-width: 440px; width: 100%;">
        <div class="card">
            <div class="card-header px-3 py-2">
                <h5 class="mb-0"><i class="fas fa-exchange-alt me-1"></i> {{ __('Swap') }}</h5>
            </div>
            <div class="card-body p-3">
                @if(session('success'))
                <div class="alert alert-success py-1 px-2 small mb-2">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger py-1 px-2 small mb-2">{{ session('error') }}</div>
                @endif

                <form action="{{ route('swap.perform') }}" method="POST" id="swap-form">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small mb-1">{{ __('From') }}</label>
                        <div id="token-from" class="searchable-select" data-tokens='@json($tokens)'>
                            <input type="text" class="form-control search-input" placeholder="{{ __('Search token...') }}" autocomplete="off">
                            <input type="hidden" name="token_from" id="token_from">
                            <div class="options d-none"></div>
                        </div>
                    </div>
                    <div class="text-center my-1">
                        <i class="fas fa-arrow-down text-secondary"></i>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small mb-1">{{ __('To') }}</label>
                        <div id="token-to" class="searchable-select" data-tokens='@json($tokens)'>
                            <input type="text" class="form-control search-input" placeholder="{{ __('Search token...') }}" autocomplete="off">
                            <input type="hidden" name="token_to" id="token_to">
                            <div class="options d-none"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small mb-1">{{ __('Amount') }}</label>
                        <div class="input-group input-group-sm">
                            <input type="text" inputmode="decimal" pattern="[0-9]*[.,]?[0-9]*" name="amount" id="amount" class="form-control amount-input" placeholder="0.0" required>
                        </div>
                        {{-- پیش‌نمایش نرخ --}}
                        <div id="swap-preview" class="mt-1 text-end small text-secondary" style="min-height: 20px;">
                            &nbsp;
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">{{ __('Swap Now') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- اسنک‌بار --}}
<div id="snackbar"
    style="visibility: hidden; min-width: 250px; background-color: #f85149; color: #fff; text-align: center; border-radius: 8px; padding: 16px; position: fixed; z-index: 9999; right: 20px; bottom: 20px; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);"
    data-message="{{ session('snackbar') }}">
</div>

<script>
    // ۱. لود قیمت‌ها برای پیش‌نمایش
    let tokenPrices = {};

    async function loadPrices() {
        try {
            const res = await fetch('/api/token-prices');
            if (!res.ok) return;
            const tokens = await res.json();
            tokens.forEach(t => tokenPrices[t.id] = parseFloat(t.price_usd));
            updatePreview();
        } catch (e) {
            console.error('Price load failed');
        }
    }

    loadPrices();

    function updatePreview() {
        const amount = parseFloat(document.getElementById('amount').value);
        const fromId = document.getElementById('token_from').value;
        const toId = document.getElementById('token_to').value;
        const previewDiv = document.getElementById('swap-preview');

        if (isNaN(amount) || !fromId || !toId || !tokenPrices[fromId] || !tokenPrices[toId]) {
            previewDiv.innerHTML = '&nbsp;';
            return;
        }

        const estimated = (amount * tokenPrices[fromId]) / tokenPrices[toId];
        const toSymbol = document.querySelector('#token-to .search-input').value || '';
        previewDiv.innerHTML = `≈ ${estimated.toFixed(6)} ${toSymbol}`;
    }

    document.getElementById('amount').addEventListener('input', updatePreview);

    // ۲. مدیریت انتخاب توکن‌ها
    document.getElementById('token_from').addEventListener('change', updatePreview);
    document.getElementById('token_to').addEventListener('change', updatePreview);

    const observer = new MutationObserver(updatePreview);
    observer.observe(document.getElementById('token_from'), {
        attributes: true,
        attributeFilter: ['value']
    });
    observer.observe(document.getElementById('token_to'), {
        attributes: true,
        attributeFilter: ['value']
    });

    // ۳. اسنک‌بار (بدون PHP داخل script)
    document.addEventListener('DOMContentLoaded', () => {
        const snackbar = document.getElementById('snackbar');
        const message = snackbar.dataset.message;
        if (message) {
            snackbar.style.visibility = 'visible';
            snackbar.style.animation = 'fadeInOut 3s forwards';
            setTimeout(() => {
                snackbar.style.visibility = 'hidden';
                snackbar.style.animation = '';
            }, 3000);
        }
    });
</script>

<style>
    @keyframes fadeInOut {
        0% {
            opacity: 0;
            bottom: 0;
        }

        10% {
            opacity: 1;
            bottom: 20px;
        }

        90% {
            opacity: 1;
            bottom: 20px;
        }

        100% {
            opacity: 0;
            bottom: 0;
        }
    }
</style>
@endsection