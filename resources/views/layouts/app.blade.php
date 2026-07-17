<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Amin Finance')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/swap-theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>
    <div id="stars-canvas"></div>

    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: rgba(22,27,34,0.9); backdrop-filter: blur(10px);">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-coins"></i> Amin Finance
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('swap.index') ? 'active' : '' }}" href="{{ route('swap.index') }}">
                                <i class="fas fa-exchange-alt me-1"></i> Swap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('swap.history') ? 'active' : '' }}" href="{{ route('swap.history') }}">
                                <i class="fas fa-history me-1"></i> History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pools.*') ? 'active' : '' }}" href="{{ route('pools.index') }}">
                                <i class="fas fa-water me-1"></i> Pools
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> Register</a>
                        </li>
                        @else
                        @if(Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-crown me-1"></i> Admin
                            </a>
                            <div class="dropdown-menu dropdown-menu-dark">
                                <a class="dropdown-item" href="{{ route('admin.tokens.index') }}">Manage Tokens</a>
                            </div>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-3">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // stars animation
        const starsContainer = document.getElementById('stars-canvas');
        for (let i = 0; i < 120; i++) {
            const star = document.createElement('div');
            star.classList.add('star');
            const size = Math.random() * 2 + 1;
            star.style.width = size + 'px';
            star.style.height = size + 'px';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 2 + 's';
            starsContainer.appendChild(star);
        }
    </script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        // initialize searchable selects on swap page
        function initSearchable(selectRoot) {
            const container = selectRoot;
            const tokens = JSON.parse(container.dataset.tokens || '[]');
            const input = container.querySelector('.search-input');
            const hidden = container.querySelector('input[type=hidden]');
            const options = container.querySelector('.options');

            function render(matches) {
                options.innerHTML = matches.map(t => `<div data-id="${t.id}" data-symbol="${t.symbol}">${t.symbol} - ${t.name}</div>`).join('');
                options.classList.toggle('d-none', matches.length === 0);
            }

            input.addEventListener('input', e => {
                const q = e.target.value.trim().toLowerCase();
                const matches = tokens.filter(t => t.symbol.toLowerCase().startsWith(q) || t.name.toLowerCase().includes(q));
                render(matches.slice(0, 50));
            });

            options.addEventListener('click', e => {
                const item = e.target.closest('div[data-id]');
                if (!item) return;
                hidden.value = item.dataset.id;
                input.value = item.dataset.symbol;
                options.classList.add('d-none');
            });

            document.addEventListener('click', e => {
                if (!container.contains(e.target)) options.classList.add('d-none');
            });
        }

        // mount searchable selects if present
        document.querySelectorAll('.searchable-select').forEach(initSearchable);

        document.querySelectorAll('.amount-input').forEach(input => {
            input.addEventListener('input', e => {
                const cleaned = e.target.value
                    .replace(/[٠-٩]/g, d => String.fromCharCode(48 + d.charCodeAt(0) - 0x0660))
                    .replace(/[۰-۹]/g, d => String.fromCharCode(48 + d.charCodeAt(0) - 0x06f0))
                    .replace(/,/g, '.')
                    .replace(/[^0-9.]/g, '');
                e.target.value = cleaned;
            });
        });

        function maybeShoot() {
            if (Math.random() < 0.08) {
                const s = document.createElement('div');
                s.className = 'shooting-star';
                s.style.left = (Math.random() * 40 + 10) + '%';
                s.style.top = (Math.random() * 60 + 10) + 'vh';
                document.body.appendChild(s);
                setTimeout(() => s.remove(), 1500);
            }
        }
        setInterval(maybeShoot, 3500);

        document.querySelectorAll('.like-widget').forEach(el => {
            const poolId = el.dataset.poolId;
            const initialLiked = el.dataset.liked === 'true';
            const initialCount = parseInt(el.dataset.count || '0');

            const app = Vue.createApp({
                data() {
                    return {
                        liked: initialLiked,
                        count: initialCount,
                        loading: false
                    };
                },
                methods: {
                    toggle() {
                        if (this.loading) return;
                        this.loading = true;
                        fetch(`/pools/${poolId}/like`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        }).then(r => {
                            if (!r.ok) throw r;
                            return r.json();
                        }).then(data => {
                            this.liked = data.liked;
                            this.count = data.count;
                        }).catch(() => {
                            alert('خطا در ارسال درخواست. لطفا وارد شوید و دوباره تلاش کنید.');
                        }).finally(() => this.loading = false);
                    }
                },
                template: `
                    <button :class="['btn btn-sm', liked ? 'btn-primary' : 'btn-outline-light']" @click.prevent="toggle" :disabled="loading">
                        <i class="fas fa-heart me-1"></i>
                        <span class="ms-1">@{{ count }}</span>
                    </button>
                `
            });

            app.mount(el);
        });
    </script>
</body>

</html>