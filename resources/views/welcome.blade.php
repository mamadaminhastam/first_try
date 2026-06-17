<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amin Finance - DeFi Exchange</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0b0f19;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            height: 100vh;
        }

        /* آسمان پرستاره با CSS */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: transparent;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle 2s infinite alternate;
        }

        @keyframes twinkle {
            0% { opacity: 0.2; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.2); }
        }

        /* شهاب سنگ */
        .shooting-star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            box-shadow: 0 0 6px 2px rgba(255,255,255,0.8);
            animation: shoot 1.5s linear infinite;
        }

        @keyframes shoot {
            0% { transform: translate(0, 0); opacity: 1; }
            70% { opacity: 1; }
            100% { transform: translate(300px, 300px); opacity: 0; }
        }

        .content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #e6edf3;
            text-align: center;
        }

        .title {
            font-size: 4rem;
            font-weight: 700;
            background: linear-gradient(135deg, #7c3aed, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .subtitle {
            font-size: 1.5rem;
            color: #8b949e;
            margin-bottom: 2rem;
        }

        .btn-dive {
            background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
            border: none;
            border-radius: 50px;
            padding: 1rem 3rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
        }

        .btn-dive:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.5);
            color: white;
        }

        /* گردباد کهکشانی در گوشه */
        .galaxy {
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }

      

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* لینک‌های بالا */
        .top-links {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 20;
        }

        .top-links a {
            color: #e6edf3;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .top-links a:hover {
            color: #7c3aed;
        }
   
    </style>
</head>
<body>
    <!-- پس‌زمینه ستاره‌ها -->
    <div class="stars" id="stars"></div>
    <!-- سیاره و کهکشان -->
    <div class="planet"></div>
    <div class="galaxy"></div>

    <!-- منوی بالای صفحه -->
    <div class="top-links">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/swap') }}">Swap</a>
                <a href="{{ route('pools.index') }}">Pools</a>
                <a href="{{ route('swap.history') }}">History</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </div>

    <!-- محتوای اصلی -->
    <div class="content">
        <div class="title">Amin Finance</div>
        <div class="subtitle">Decentralized Trading, Redefined</div>
        <a href="{{ url('/swap') }}" class="btn-dive">🚀 Let's Dive</a>
    </div>

    <script>
        // ساخت ستاره‌ها به صورت داینامیک
        const starsContainer = document.getElementById('stars');
        const numberOfStars = 150;

        for (let i = 0; i < numberOfStars; i++) {
            const star = document.createElement('div');
            star.classList.add('star');
            const size = Math.random() * 3 + 1;
            star.style.width = size + 'px';
            star.style.height = size + 'px';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 2 + 's';
            starsContainer.appendChild(star);
        }

        // شهاب سنگ تصادفی
        setInterval(() => {
            const shootingStar = document.createElement('div');
            shootingStar.classList.add('shooting-star');
            shootingStar.style.left = Math.random() * 80 + '%';
            shootingStar.style.top = Math.random() * 40 + '%';
            document.body.appendChild(shootingStar);
            setTimeout(() => shootingStar.remove(), 1500);
        }, 3000);
    </script>
</body>
</html>