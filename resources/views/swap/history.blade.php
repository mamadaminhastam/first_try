@extends('layouts.app')

@section('title', __('Transaction History') . ' - Amin Finance')

@section('content')
<div class="container">
    <h1 class="mb-4">📜 {{ __('Transaction History') }}</h1>

    @if($transactions->isEmpty())
    <div class="alert alert-info">{{ __('No transactions yet.') }} Go <a href="{{ route('swap.index') }}">swap some tokens</a>!</div>
    @else
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <div class="btn-group btn-group-sm" role="group" aria-label="filter">
                <a href="?filter=today" class="btn btn-outline-light btn-sm">{{ __('Today') }}</a>
                <a href="?filter=week" class="btn btn-outline-light btn-sm">{{ __('This Week') }}</a>
                <a href="?filter=month" class="btn btn-outline-light btn-sm">{{ __('This Month') }}</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-head-custom">
                <tr>
                    <th>{{ __('From') }}</th>
                    <th>{{ __('To') }}</th>
                    <th>{{ __('Amount From') }}</th>
                    <th>{{ __('Amount To') }}</th>
                    <th>{{ __('Rate') }}</th>
                    <th>{{ __('Date') }}</th>
                </tr>
            </thead>
            <tbody id="transactions-body" data-current-page="{{ $transactions->currentPage() }}">
                @include('swap._transactions_rows', ['transactions' => $transactions])
            </tbody>
        </table>
    </div>

    <script>
        (function() {
            let loading = false;
            let tbody = document.getElementById('transactions-body');
            let currentPage = parseInt(tbody.dataset.currentPage || '1');

            function appendHtml(html) {
                const tmp = document.createElement('tbody');
                tmp.innerHTML = html;
                Array.from(tmp.children).forEach(node => tbody.appendChild(node));
            }

            async function loadNext() {
                if (loading || !hasMore) return;
                loading = true;
                const nextPage = currentPage + 1;
                try {
                    const url = new URL(window.location.href);
                    url.searchParams.set('page', nextPage);
                    const res = await fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('Network error');
                    const data = await res.json();
                    if (data.html) {
                        appendHtml(data.html);
                        currentPage = data.currentPage;
                        hasMore = data.hasMore;
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    loading = false;
                }
            }

            window.addEventListener('scroll', () => {
                if (!hasMore || loading) return;
                const scrolled = window.scrollY + window.innerHeight;
                const near = document.body.scrollHeight - 300;
                if (scrolled >= near) loadNext();
            });
        })();
    </script>
    @endif
</div>
@endsection