@extends('layouts.app')

@section('title', 'Manage Tokens - Admin')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-coins me-2"></i> Manage Tokens</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Price (USD)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tokens as $token)
                <tr>
                    <td>
                        <img src="{{ asset('icons/tokens/' . strtolower($token->symbol) . '.svg') }}" 
                             onerror="this.onerror=null;this.src=fallbackIcon;"
                             width="24" height="24" alt="{{ $token->symbol }}" style="vertical-align: middle;">
                    </td>
                    <td>{{ $token->name }}</td>
                    <td><span class="badge bg-info">{{ $token->symbol }}</span></td>
                    <td>{{ $token->price_usd }}</td>
                    <td>
                        <form action="{{ route('admin.tokens.destroy', $token) }}" method="POST" onsubmit="return confirm('Delete this token?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $tokens->links() }}
</div>

{{-- تعریف متغیر fallback برای تصاویر --}}
<script>
    var fallbackIcon = "{{ asset('icons/tokens/generic.svg') }}";
</script>
@endsection