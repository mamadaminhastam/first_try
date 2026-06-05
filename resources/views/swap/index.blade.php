@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">⚡ Swap Tokens</h4>
                </div>
                <div class="card-body">
                    {{-- نمایش پیام‌ها --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
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

                    <form action="{{ route('swap.perform') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="token_from" class="form-label">From Token</label>
                            <select name="token_from" class="form-select form-select-lg" required>
                                <option value="">Select token</option>
                                @foreach($tokens as $token)
                                    <option value="{{ $token->id }}">
                                        <span class="badge bg-secondary me-2">{{ $token->symbol }}</span> {{ $token->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div class="mb-3">
                            <label for="token_to" class="form-label">To Token</label>
                            <select name="token_from" class="form-select form-select-lg" required>
                                <option value="">Select token</option>
                                @foreach($tokens as $token)
                                    <option value="{{ $token->id }}">
                                        <span class="badge bg-secondary me-2">{{ $token->symbol }}</span> {{ $token->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="any" name="amount" id="amount" class="form-control" placeholder="0.0" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Swap Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection