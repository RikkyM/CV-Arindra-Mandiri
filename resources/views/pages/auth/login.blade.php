<x-components.layouts.auth title="Masuk">
    <section class="flex h-screen w-full flex-col items-center justify-center bg-[#FAFAFA] px-1.5">
        <form action="{{ route('login') }}" method="POST"
            class="flex w-full max-w-sm flex-col gap-5 rounded-md border border-gray-300 bg-white px-5 py-3 shadow-md">
            @csrf
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 font-semibold capitalize">
                <svg class="size-7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m6.921 12.5l5.792 5.792L12 19l-7-7l7-7l.713.708L6.921 11.5H19v1H6.921Z"
                        fill="currentColor" />
                </svg>
                <span class="font-semibold">home</span>
            </a>
            <div>
                @if (Session::has('success'))
                    <div class="rounded-sm bg-green-500 p-3">
                        <p class="font-semibold text-white text-sm">{{ Session::get('success') }}</p>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="rounded-sm bg-red-500 p-3">
                        <p class="font-semibold text-white text-sm">{{ Session::get('error') }}</p>
                    </div>
                @endif
            </div>
            <h1 class="inline-block border-b border-gray-300 pb-3 text-2xl font-bold capitalize">masuk</h1>
            <label for="email" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                <span class="font-semibold">E-Mail</span>
                <input type="email" name="email" id="email" required
                    class="rounded-sm border border-gray-300 p-2 text-sm placeholder:italic"
                    placeholder="Isi alamat e-mail">
                @error('email')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="password" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                <span class="font-semibold">Kata Sandi</span>
                <input type="password" name="password" id="password" required
                    class="rounded-sm border border-gray-300 p-2 text-sm placeholder:italic"
                    placeholder="Isi kata sandi">
                @error('password')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="w-full">
                <button type="submit"
                    class="w-full rounded-md bg-teal-500 p-2 text-lg font-bold text-white">Masuk</button>
                <p class="mt-2 capitalize">belum punya akun ? <a href="{{ route('register') }}"
                        class="text-blue-500 underline">daftar disini</a></p>
            </div>
        </form>
    </section>
</x-components.layouts.auth>
