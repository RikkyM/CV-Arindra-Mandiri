<x-components.layouts.auth title="Daftar">
    <section class="flex h-screen w-full flex-col items-center justify-center bg-[#FAFAFA] px-1.5">
        <form action="{{ route('register') }}" method="POST"
            class="flex w-full max-w-sm flex-col gap-5 rounded-md border border-gray-300 bg-white px-5 py-3 shadow-md">
            @csrf
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 font-semibold capitalize">
                <svg class="size-7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m6.921 12.5l5.792 5.792L12 19l-7-7l7-7l.713.708L6.921 11.5H19v1H6.921Z"
                        fill="currentColor" />
                </svg>
                <span class="font-semibold">home</span>
            </a>
            <h1 class="inline-block border-b border-gray-300 pb-3 text-2xl font-bold capitalize">daftar</h1>
            <label for="nama_depan" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                <span class="font-semibold">Nama Depan</span>
                <input type="nama_depan" id="nama_depan" name="nama_depan"
                    class="rounded-sm border border-gray-300 p-2 text-sm placeholder:capitalize placeholder:italic"
                    placeholder="nama depan">
                @error('nama_depan')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="nama_belakang" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                <span class="font-semibold">Nama Belakang</span>
                <input type="nama_belakang" id="nama_belakang" name="nama_belakang"
                    class="rounded-sm border border-gray-300 p-2 text-sm placeholder:capitalize placeholder:italic"
                    placeholder="nama belakang">
                @error('nama_belakang')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="username" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                <span class="font-semibold">Username</span>
                <input type="username" id="username" name="username"
                    class="rounded-sm border border-gray-300 p-2 text-sm placeholder:italic"
                    placeholder="Username">
                @error('username')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="grid grid-cols-2 gap-4">
                <label for="password" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                    <span class="font-semibold">Kata Sandi</span>
                    <input type="password" id="password" name="password"
                        class="rounded-sm border border-gray-300 p-2 text-sm placeholder:capitalize placeholder:italic"
                        placeholder="kata sandi">
                    @error('password')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
                <label for="password_confirmation" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                    <span class="pointer-events-none font-semibold opacity-0">Konfirmasi Kata Sandi</span>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="rounded-sm border border-gray-300 p-2 text-sm placeholder:capitalize placeholder:italic"
                        placeholder="konfirmasi kata sandi">
                </label>
            </div>
            <label for="jenis_akun" class="mx-auto flex w-full max-w-sm flex-col gap-1.5">
                <span class="font-semibold">Jenis Akun</span>
                <select name="jenis_akun" id="jenis_akun"
                    class="rounded-sm border border-gray-300 p-2 text-sm placeholder:italic">
                    <option value="">-- Pilih --</option>
                    <option value="toko">Toko</option>
                    <option value="konsumen">Konsumen</option>
                </select>
                @error('jenis_akun')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="w-full">
                <button type="submit"
                    class="w-full rounded-md bg-teal-500 p-2 text-lg font-bold text-white">Daftar</button>
                <p class="mt-2 capitalize">sudah punya akun ? <a href="{{ route('login') }}"
                        class="text-blue-500 underline">masuk disini</a></p>
            </div>
        </form>
    </section>
</x-components.layouts.auth>
