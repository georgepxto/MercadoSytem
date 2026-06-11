<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login — Feirante</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Rubik', sans-serif;
            -webkit-font-smoothing: antialiased;
            background: #0F0E0A;
            color: #E8E4D9;
        }

        .page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }

        /* Dois pontos de luz ambiente */
        .page::before,
        .page::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(80px);
        }

        .page::before {
            width: 400px;
            height: 400px;
            background: rgba(16, 185, 129, 0.07);
            top: -10%;
            right: -5%;
        }

        .page::after {
            width: 350px;
            height: 350px;
            background: rgba(99, 102, 241, 0.05);
            bottom: -10%;
            left: -5%;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            animation: rise 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Topo: marca */
        .brand {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 2rem;
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #10B981;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .brand-text h1 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #E8E4D9;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 0.8rem;
            color: #6B6254;
            margin-top: 0.15rem;
        }

        /* Card do formulário */
        .form-card {
            background: #171510;
            border: 1px solid rgba(255,255,255,0.055);
            border-radius: 14px;
            padding: 1.75rem;
        }

        .field + .field { margin-top: 1.125rem; }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #6B6254;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.45rem;
        }

        .input-wrap { position: relative; }

        .input-wrap i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B6254;
            font-size: 0.9rem;
            pointer-events: none;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.72rem 1rem 0.72rem 2.5rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 9px;
            color: #E8E4D9;
            font-family: 'Rubik', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.18s, background 0.18s;
        }

        input::placeholder {
            color: rgba(107,98,84,0.55);
        }

        input:focus {
            border-color: #10B981;
            background: rgba(16,185,129,0.04);
            box-shadow: 0 0 0 3px rgba(16,185,129,0.08);
        }

        /* Remember me */
        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.125rem;
        }

        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 5px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.04);
            cursor: pointer;
            padding: 0;
            accent-color: #10B981;
        }

        .remember label {
            font-size: 0.85rem;
            color: #6B6254;
            letter-spacing: 0;
            text-transform: none;
            margin: 0;
            cursor: pointer;
        }

        /* Botão */
        .btn-enter {
            width: 100%;
            margin-top: 1.5rem;
            padding: 0.78rem;
            background: #10B981;
            border: none;
            border-radius: 9px;
            color: #fff;
            font-family: 'Rubik', sans-serif;
            font-size: 0.925rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.18s, box-shadow 0.18s, transform 0.12s;
            position: relative;
            overflow: hidden;
        }

        .btn-enter:hover {
            background: #059669;
            box-shadow: 0 4px 20px rgba(16,185,129,0.22);
            transform: translateY(-1px);
        }

        .btn-enter:active {
            transform: translateY(0);
        }

        .btn-enter.loading { color: transparent; }

        .btn-enter.loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%; left: 50%;
            margin: -9px 0 0 -9px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Erro */
        .error-box {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.16);
            border-radius: 9px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            color: #FCA5A5;
            display: flex;
            gap: 0.5rem;
            align-items: flex-start;
        }

        @media (max-width: 480px) {
            .page { align-items: flex-start; padding-top: 2.5rem; }
            .form-card { padding: 1.25rem; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="login-box">
        <div class="brand">
            <div class="brand-mark">
                <i class="bi bi-shop"></i>
            </div>
            <div class="brand-text">
                <h1>Feirante</h1>
                <p>Controle de boxes e vendedores</p>
            </div>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="error-box">
                    <i class="bi bi-exclamation-circle flex-shrink-0" style="margin-top:2px;"></i>
                    <span>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="field">
                    <label for="email">E-mail</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope"></i>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="seu@email.com">
                    </div>
                </div>

                <div class="field">
                    <label for="password">Senha</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password"
                               required autocomplete="current-password"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Lembrar de mim</label>
                </div>

                <button type="submit" class="btn-enter" id="submitBtn">Entrar</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.classList.add('loading');
        btn.disabled = true;
        setTimeout(() => { btn.classList.remove('loading'); btn.disabled = false; }, 10000);
    });
</script>
</body>
</html>
