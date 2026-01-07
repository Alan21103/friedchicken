<x-guest-layout>
    <div class="w-full md:w-1/2 bg-[#1a120b] hidden md:flex items-center justify-center relative">
        <img src="{{ asset('images/logo-chicken.png') }}" 
             alt="My Fried Chiken Logo" 
             class="w-full h-full object-cover">
    </div>

    <div class="w-full md:w-1/2 p-10 md:p-20 flex flex-col justify-center bg-white">
        <div class="max-w-md mx-auto w-full">
            <h2 class="text-[32px] font-bold text-black leading-tight mb-2">
                Selamat Datang di <br> My Fried Chiken.
            </h2>
            <p class="text-[14px] text-[#9CA3AF] mb-10">
                Masukkan username dan password Anda untuk melanjutkan
            </p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-8">
                    <label for="email" class="block text-[14px] text-[#8B8D97] mb-1">Username</label>
                    <div class="relative border-b border-gray-200 focus-within:border-[#332B2B] transition-colors">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            placeholder="Masukkan username anda"
                            class="w-full border-none focus:ring-0 p-0 py-2 text-black placeholder-gray-300 text-[15px] bg-transparent">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-1 pointer-events-none text-gray-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-12">
                    <label for="password" class="block text-[14px] text-[#8B8D97] mb-1">Password</label>
                    <div class="relative border-b border-gray-200 focus-within:border-[#332B2B] transition-colors">
                        <input id="password" type="password" name="password" required 
                            placeholder="Masukkan password anda"
                            class="w-full border-none focus:ring-0 p-0 py-2 text-black placeholder-gray-300 text-[15px] bg-transparent">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-1 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <button type="submit" 
                    class="w-full bg-[#332B2B] text-white font-semibold py-4 rounded-xl hover:bg-[#252020] transition-all shadow-md active:scale-[0.98]">
                    Login
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>