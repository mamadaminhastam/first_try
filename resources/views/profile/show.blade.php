@extends('layouts.app')

@section('title', __('Profile') . ' - ' . Auth::user()->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-circle me-2"></i> {{ __('Profile') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small">{{ __('Role') }}</label>
                            <div class="fw-bold">
                                @if($user->role === 'admin')
                                <span class="badge bg-danger">{{ __('Admin') }}</span>
                                @else
                                <span class="badge bg-secondary">{{ __('User') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small">{{ __('Registered Since') }}</label>
                            <div class="fw-bold">{{ $user->created_at->format('Y-m-d') }}</div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> {{ __('Update Profile') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Token Balances --}}
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-coins me-2"></i> {{ __('My Token Balances') }}
                </div>
                <div class="card-body">
                    @if($balances->isEmpty())
                    <p class="text-secondary">{{ __('You have no tokens.') }}</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-dark table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Token') }}</th>
                                    <th>{{ __('Symbol') }}</th>
                                    <th>{{ __('Balance') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($balances as $balance)
                                <tr>
                                    <td>{{ $balance->token->name }}</td>
                                    <td><span class="badge bg-info">{{ $balance->token->symbol }}</span></td>
                                    <td>{{ number_format($balance->balance, 6) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection