<x-layouts.admin title="Tambah User">
    <section class="mx-auto flex h-full max-w-screen-sm items-center justify-center">
        <form action="{{ route('add-user') }}" method="POST"
            class="mb-3 flex w-full max-w-xs flex-col gap-3 border border-gray-300 bg-white p-3">
            @csrf
            <h1 class="text-2xl font-semibold">Tambah User</h1>
            <label for="nama_lengkap" class="flex flex-col">
                <span class="text-sm">Nama Lengkap</span>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Masukkan nama lengkap...">
                @error('nama_lengkap')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            {{-- <label for="alamat" class="flex flex-col">
                <span class="text-sm">Alamat</span>
                <textarea placeholder="Masukkan alamat..." name="alamat" id="alamat"
                    class="rounded-sm border border-gray-300 p-2 text-sm max-h-32"></textarea>
                @error('alamat')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label> --}}

            <label for="no_hp" class="flex flex-col">
                <span class="text-sm">Nomor HP</span>
                <div class="flex w-full">
                    <label for="country_code" class="select-none">
                        <input type="text" name="country_code" value="+62" min="1" readonly tabindex="-1"
                            class="pointer-events-none w-[6ch] bg-gray-300 p-2 text-center outline-none">
                    </label>
                    <input type="number" id="no_hp" name="no_hp" minlength="11" maxlength="12" required
                        class="w-full rounded-sm border border-gray-300 p-2 text-sm [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                        placeholder="Masukkan nomor hp...">
                </div>
                @error('no_hp')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="password" class="flex flex-col">
                <span class="text-sm">Kata Sandi</span>
                <input type="password" id="password" name="password" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Masukkan kata sandi...">
                @error('password')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="role" class="flex flex-col">
                <span class="text-sm">Role</span>
                <select name="role" id="role" class="rounded-sm border border-gray-300 p-2 text-sm" required>
                    <option value="">-- Pilih --</option>
                    <option value="toko">Toko</option>
                    <option value="konsumen">Konsumen</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="status_akun" class="flex flex-col">
                <span class="text-sm">Status Akun</span>
                <select name="status_akun" id="status_akun" class="rounded-sm border border-gray-300 p-2 text-sm" required>
                    <option value="">-- Pilih --</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status_akun')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="w-full">
                <button type="submit" class="w-full bg-green-500 p-2 font-semibold text-white">Tambahkan</button>
            </div>
        </form>
    </section>
</x-layouts.admin>
