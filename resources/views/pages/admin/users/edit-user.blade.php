<x-layouts.admin title="Edit User">
    <section class="mx-auto flex h-full max-w-screen-sm items-center justify-center">
        <form action="{{ route('edit-user', $user->id) }}" method="POST"
            class="mb-3 flex w-full max-w-xs flex-col gap-3 border border-gray-300 bg-white p-3">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-semibold">Edit User</h1>
            <label for="nama_lengkap" class="flex flex-col">
                <span class="text-sm">Nama Lengkap</span>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $user->name }}"
                    class="rounded-sm border border-gray-300 p-2 text-sm capitalize" placeholder="Masukkan nama lengkap...">
                @error('nama_lengkap')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="no_hp" class="flex flex-col">
                <span class="text-sm">Nomor HP</span>
                <div class="flex w-full">
                    <label for="country_code" class="select-none">
                        <input type="text" name="country_code" value="+62" min="1" readonly tabindex="-1"
                            class="pointer-events-none w-[6ch] bg-gray-300 p-2 text-center outline-none">
                    </label>
                    <input type="number" id="no_hp" name="no_hp" minlength="11" maxlength="12" value="{{ $user->username }}"
                        class="w-full rounded-sm border border-gray-300 p-2 text-sm [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                        placeholder="Masukkan nomor hp...">
                </div>
                @error('no_hp')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="role" class="flex flex-col">
                <span class="text-sm">Role</span>
                <select name="role" id="role" class="rounded-sm border border-gray-300 p-2 text-sm">
                    <option value="">-- Pilih --</option>
                    <option value="toko" {{ $user->role == 'toko' ? 'selected' : '' }}>Toko</option>
                    <option value="konsumen" {{ $user->role == 'konsumen' ? 'selected' : '' }}>Konsumen</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="h-[1px] w-full bg-gray-300 my-3"></div>

            <label for="password" class="flex flex-col">
                <span class="text-sm">Kata Sandi</span>
                <input type="password" id="password" name="password"
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Masukkan kata sandi...">
                @error('password')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="password_confirmation" class="flex flex-col">
                <span class="text-sm">Konfirmasi Kata Sandi</span>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Masukkan kata sandi...">
                @error('password_confirmation')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="w-full">
                <button type="submit" class="w-full bg-blue-500 rounded p-2 font-semibold text-white">Ubah Data User</button>
            </div>
        </form>
    </section>
</x-layouts.admin>
