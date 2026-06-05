@extends('layouts.app')

@section('title', 'Create Pool')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i> Create Liquidity Pool
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pools.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="token_a_id" class="form-label">Token A</label>
                            <select name="token_a_id" id="token_a_id" class="form-select" required>
                                <option value="">Select Token</option>
                                @foreach($tokens as $token)
                                    <option value="{{ $token->id }}">{{ $token->symbol }} - {{ $token->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center my-3">
                            <i class="fas fa-plus text-secondary"></i>
                        </div>
                        <div class="mb-3">
                            <label for="token_b_id" class="form-label">Token B</label>
                            <select name="token_b_id" id="token_b_id" class="form-select" required>
                                <option value="">Select Token</option>
                                @foreach($tokens as $token)
                                    <option value="{{ $token->id }}">{{ $token->symbol }} - {{ $token->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fee_percent" class="form-label">Fee (%)</label>
                            <input type="number" step="0.01" name="fee_percent" class="form-control" value="0.3">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create Pool</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection