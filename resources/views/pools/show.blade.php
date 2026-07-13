@extends('layouts.app')

@section('title', $pool->tokenA->symbol . '/' . $pool->tokenB->symbol . ' Pool')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- نمودار قیمت --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-2"></i>
                    <span class="badge bg-info">{{ $pool->tokenA->symbol }}</span> /
                    <span class="badge bg-warning text-dark">{{ $pool->tokenB->symbol }}</span> Chart
                </div>
                <div class="card-body p-0">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container" style="height:500px;">
                        <div id="tradingview_chart" style="height:100%;"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                        <script type="text/javascript">
                            new TradingView.widget({
                                "autosize": true,
                                "symbol": "BINANCE:{{ $pool->tokenA->symbol }}{{ $pool->tokenB->symbol }}",
                                "interval": "60",
                                "timezone": "Etc/UTC",
                                "theme": "dark",
                                "style": "1",
                                "locale": "en",
                                "toolbar_bg": "#1c2128",
                                "enable_publishing": false,
                                "allow_symbol_change": false,
                                "container_id": "tradingview_chart"
                            });
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>

            {{-- اطلاعات استخر و نقدینگی کاربر --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-chart-pie me-2"></i>
                        <span class="badge bg-info">{{ $pool->tokenA->symbol }}</span> /
                        <span class="badge bg-warning text-dark">{{ $pool->tokenB->symbol }}</span>
                    </span>
                    <span class="badge bg-secondary">Fee {{ $pool->fee_percent }}%</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="bg-dark p-3 rounded-3 text-center">
                                <div class="text-secondary small">Total {{ $pool->tokenA->symbol }}</div>
                                <div class="fw-bold fs-5">{{ number_format($pool->reserve_a, 4) }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-dark p-3 rounded-3 text-center">
                                <div class="text-secondary small">Total {{ $pool->tokenB->symbol }}</div>
                                <div class="fw-bold fs-5">{{ number_format($pool->reserve_b, 4) }}</div>
                            </div>
                        </div>
                    </div>
                    <h5>Your Liquidity</h5>
                    @if($userContribution)
                    <div class="bg-dark p-3 rounded-3 mb-3">
                        <span>LP Tokens: <strong>{{ number_format($userContribution->lp_tokens, 6) }}</strong></span>
                        <span class="ms-3">Share: <strong>{{ $pool->total_lp_tokens > 0 ? number_format(($userContribution->lp_tokens / $pool->total_lp_tokens) * 100, 2) : 0 }}%</strong></span>
                    </div>
                    @else
                    <p class="text-secondary">No liquidity provided yet.</p>
                    @endif

                    {{-- دکمه‌ها: ادمین دو دکمه کنار هم، کاربر عادی فقط Add Liquidity --}}
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <div class="row mt-3">
                        <div class="col-6">
                            <form action="{{ route('pools.destroy', $pool) }}" method="POST" onsubmit="return confirm('آیا از حذف استخر مطمئن هستید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i> Delete Pool
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('pools.addLiquidity', $pool) }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-1"></i> Add Liquidity
                            </a>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('pools.addLiquidity', $pool) }}" class="btn btn-primary w-100 mt-3">
                        <i class="fas fa-plus me-1"></i> Add Liquidity
                    </a>
                    @endif
                    @endauth
                </div>
            </div>
            <div class="text-center text-secondary small mt-3">
                <i class="fas fa-shield-alt me-1"></i> Assets are simulated — not real blockchain funds.
            </div>
        </div>
    </div>
</div>
@endsection