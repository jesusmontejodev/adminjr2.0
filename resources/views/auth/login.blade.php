<x-guest-layout>

    <!-- CARD -->
    <div class="login-card relative z-10 max-w-md mx-auto mt-16
                border border-red-500/30
                rounded-3xl
                px-8 py-10">

        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('avaspace.svg') }}" class="h-10" alt="Admin Jr">
        </div>

        <!-- Title -->
        <h1 class="text-center text-white text-xl font-bold mb-1">
            Bienvenida a <span class="text-red-500">Admin Jr</span>
        </h1>

        <p class="text-center text-gray-400 text-sm mb-8">
            Inicia sesión para continuar
        </p>

        <!-- Status -->
        <x-auth-session-status
            class="mb-4 text-center"
            :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label
                    for="email"
                    value="Email"
                    class="login-label" />

                <x-text-input
                    id="email"
                    class="login-input block w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username" />

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label
                    for="password"
                    value="Password"
                    class="login-label" />

                <x-text-input
                    id="password"
                    class="login-input block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded bg-[#020617] border-white/20 text-red-600 focus:ring-red-500"
                    name="remember">
                Remember me
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-2">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-gray-400 hover:text-red-400 transition">
                        Forgot password?
                    </a>
                @endif

                <x-primary-button class="login-btn">
                    LOG IN
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- STYLES -->
    <style>
        /* Layout base */
        main {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            justify-content: flex-start !important;
            padding-top: 4rem;
        }

        /* CARD */
        .login-card {
            background: linear-gradient(
                180deg,
                rgba(255,255,255,0.06),
                rgba(255,255,255,0.02)
            );
            backdrop-filter: blur(18px);
            transition: all .35s ease;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background: radial-gradient(
                circle,
                rgba(104, 26, 26, 0.44),
                transparent 30%
            );
            opacity: 0;
            transition: opacity .4s ease;
            z-index: -1;
        }

        .login-card:hover::before {
            opacity: 1;
        }

        .login-card:hover {
            border-color: rgba(239,68,68,.55);
            box-shadow: 0 0 35px rgba(239,68,68,.15);
        }

        /* LABELS (SIN FONDO) */
        .login-label {
            display: block;
            background: transparent !important;
            color: #ef4444;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .3px;
            margin-bottom: 4px;
        }

        /* INPUTS */
        .login-input {
            margin-top: 6px;
            padding: 12px 16px;
            border-radius: 14px;

            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);

            color: #e5e7eb;
            transition: .25s ease;
        }

        .login-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        .login-input:focus {
            outline: none;
            border-color: #ef4444;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 2px rgba(239, 68, 68, .35);
        }

        /* BOTÓN */
        .login-btn {
            background: transparent;
            border: 1.5px solid rgba(239,68,68,.6);
            color: #ef4444;
            padding: 10px 22px;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: .5px;
            transition: all .3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: #fff;
            box-shadow: 0 6px 20px rgba(239,68,68,.35);
            transform: translateY(-2px);
        }
    </style>

</x-guest-layout>