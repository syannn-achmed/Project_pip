<x-guest-layout>
    <!-- Header Title -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-black text-gray-900">Masuk ke Sistem</h2>
        <p class="text-xs text-gray-500 mt-1">Silakan masukkan email dan kata sandi akun Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700 text-xs" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="nama@sekolah.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700 text-xs" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 transition" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                type="password"
                name="password"
                required autocomplete="current-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text-xs font-medium text-gray-600">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/20 transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Masuk Sekarang
            </button>
        </div>
    </form>

    <!-- Quick Credentials Helper for Demo / Testing -->
    <div class="mt-6 pt-5 border-t border-dashed border-gray-200">
        <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 block mb-2 text-center">Bantuan Akses Default</span>
        <div class="grid grid-cols-3 gap-1.5 text-center text-[10px]">
            <button type="button" onclick="fillCred('admin@sekolah.com')" class="p-1.5 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-800 rounded-lg border border-gray-200 transition">
                <strong>Admin TU</strong>
            </button>
            <button type="button" onclick="fillCred('kepsek@sekolah.com')" class="p-1.5 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-800 rounded-lg border border-gray-200 transition">
                <strong>Kepsek</strong>
            </button>
            <button type="button" onclick="fillCred('ortu@sekolah.com')" class="p-1.5 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-800 rounded-lg border border-gray-200 transition">
                <strong>Orang Tua</strong>
            </button>
        </div>
    </div>

    <script>
        function fillCred(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password123';
        }
    </script>
</x-guest-layout>
