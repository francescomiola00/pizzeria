<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Login') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --orange:     #E8820C;
            --orange-dk:  #C46A00;
            --dark:       #1A1A1A;
            --dark-2:     #242424;
            --dark-3:     #2E2E2E;
            --text:       #F0EDE8;
            --text-muted: #9A9080;
            --error:      #E05555;
        }

        html, body {
            height: 100%;
            font-family: 'Jost', sans-serif;
            background-color: var(--dark);
            color: var(--text);
        }

        /* ── Layout ─────────────────────────── */
        .login-wrap {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 480px;
        }

        /* ── Pannello sinistro – immagine ────── */
        .login-visual {
            position: relative;
            overflow: hidden;
            background: var(--dark-2);
        }

        .login-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(232,130,12,.55) 0%, transparent 60%),
                url('https://images.unsplash.com/photo-1513104890138-7c749659a591?w=1200&q=80') center/cover no-repeat;
            filter: brightness(.75) saturate(1.1);
        }

        .login-visual::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, transparent 60%, var(--dark) 100%);
        }

        .visual-content {
            position: relative;
            z-index: 2;
            padding: 60px 48px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .visual-tagline {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
            color: #fff;
            text-shadow: 0 2px 24px rgba(0,0,0,.5);
            margin-bottom: 12px;
        }

        .visual-sub {
            font-size: .95rem;
            font-weight: 300;
            color: rgba(255,255,255,.65);
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .visual-line {
            width: 48px;
            height: 2px;
            background: var(--orange);
            margin-bottom: 20px;
        }

        /* ── Pannello destro – form ───────────── */
        .login-panel {
            background: var(--dark);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 64px 48px;
            border-left: 1px solid rgba(255,255,255,.06);
        }

        .login-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 56px;
        }

        .login-heading {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .login-subheading {
            font-size: .875rem;
            color: var(--text-muted);
            font-weight: 300;
            margin-bottom: 40px;
        }

        /* ── Alert errore ───────────────────── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: .875rem;
            margin-bottom: 28px;
            border: 1px solid;
        }

        .alert-error {
            background: rgba(224,85,85,.1);
            border-color: rgba(224,85,85,.3);
            color: #F08080;
        }

        .alert-warning {
            background: rgba(232,130,12,.1);
            border-color: rgba(232,130,12,.3);
            color: var(--orange);
        }

        .alert-icon { font-size: 1rem; flex-shrink: 0; }

        /* ── Campi form ─────────────────────── */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .field-inner {
            position: relative;
        }

        .field-inner .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color .2s;
        }

        .field input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            background: var(--dark-3);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 6px;
            color: var(--text);
            font-family: 'Jost', sans-serif;
            font-size: .95rem;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .field input:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(232,130,12,.15);
        }

        .field input:focus + .icon,
        .field-inner:focus-within .icon {
            color: var(--orange);
        }

        /* toggle password */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: .85rem;
            padding: 4px;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--text); }

        /* ── Bottone submit ─────────────────── */
        .btn-login {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-family: 'Jost', sans-serif;
            font-size: .9rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .2s, transform .1s, box-shadow .2s;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
            pointer-events: none;
        }

        .btn-login:hover  { background: var(--orange-dk); box-shadow: 0 4px 20px rgba(232,130,12,.35); }
        .btn-login:active { transform: scale(.98); }

        /* ── Footer panel ───────────────────── */
        .panel-footer {
            margin-top: 48px;
            font-size: .8rem;
            color: var(--text-muted);
            text-align: center;
        }

        .panel-footer a {
            color: var(--orange);
            text-decoration: none;
        }

        /* ── Responsive ─────────────────────── */
        @media (max-width: 768px) {
            .login-wrap { grid-template-columns: 1fr; }
            .login-visual { display: none; }
            .login-panel { padding: 48px 28px; }
        }

        /* ── Animazione entrata ─────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-panel > * {
            animation: fadeUp .5s ease both;
        }
        .login-logo        { animation-delay: .05s; }
        .login-heading     { animation-delay: .12s; }
        .login-subheading  { animation-delay: .17s; }
        .alert             { animation-delay: .20s; }
        .field:nth-child(1){ animation-delay: .22s; }
        .field:nth-child(2){ animation-delay: .27s; }
        .btn-login         { animation-delay: .32s; }
        .panel-footer      { animation-delay: .38s; }
    </style>
</head>
<body>

<div class="login-wrap">

    <!-- ── Pannello visivo ────────────────────── -->
    <div class="login-visual">
        <div class="visual-content">
            <div class="visual-line"></div>
            <p class="visual-tagline">La pizza<br>che racconta<br>una storia.</p>
            <p class="visual-sub">Pannello di gestione</p>
        </div>
    </div>

    <!-- ── Form login ─────────────────────────── -->
    <div class="login-panel">

        <div class="login-logo"><?= htmlspecialchars(PIZZERIA_NAME) ?></div>

        <h1 class="login-heading">Accesso<br>Amministratore</h1>
        <p class="login-subheading">Inserisci le tue credenziali per continuare</p>

        <?php if (!empty($expired)): ?>
            <div class="alert alert-warning">
                <span class="alert-icon">⏱</span>
                <span>Sessione scaduta. Effettua di nuovo il login.</span>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-error">
                <span class="alert-icon">⚠</span>
                <span>
                    <?php if ($error === 'empty'): ?>
                        Inserisci username e password.
                    <?php else: ?>
                        Credenziali non valide. Riprova.
                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/admin/login" novalidate>
                    <?= Auth::csrfField() ?>

            <div class="field">
                <label for="username">Username</label>
                <div class="field-inner">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        autocomplete="username"
                        required
                        autofocus
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                    >
                    <span class="icon">👤</span>
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="field-inner">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                    <span class="icon">🔒</span>
                    <button type="button" class="toggle-pw" onclick="togglePassword()" title="Mostra/Nascondi password">
                        <span id="pw-eye">👁</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">Accedi</button>

        </form>

        <div class="panel-footer">
            <a href="<?= BASE_URL ?>/">← Torna al sito</a>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eye   = document.getElementById('pw-eye');
    if (input.type === 'password') {
        input.type = 'text';
        eye.textContent = '🙈';
    } else {
        input.type = 'password';
        eye.textContent = '👁';
    }
}
</script>

</body>
</html>