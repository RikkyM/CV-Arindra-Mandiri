<x-layouts.admin title="Tambah User">
    <section class="mx-auto flex h-full max-w-screen-sm items-center justify-center">
        <form action="{{ route('add-product') }}" method="POST" enctype="multipart/form-data"
            class="mb-3 flex w-full max-w-xs flex-col gap-3 border border-gray-300 bg-white p-3">
            @csrf
            <h1 class="text-2xl font-semibold">Tambah User</h1>
            <label for="nama_lengkap" class="flex flex-col">
                <span class="text-sm">Nama Lengkap</span>
                <input type="text" id="nama_lengkap" name="nama_lengkap"
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Masukkan nama lengkap...">
                @error('nama_lengkap')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="alamat" class="flex flex-col">
                <span class="text-sm">Alamat</span>
                <input type="text" id="alamat" name="alamat"
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Masukkan alamat...">
                @error('alamat')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="no_hp" class="flex flex-col">
                <span class="text-sm">Nomor HP</span>
                <div class="flex w-full">
                    <input type="text" value="+62" min="1" readonly class="w-[6ch] bg-gray-300 text-center p-2">
                    <input type="number" id="no_hp" name="no_hp" 
                    class="w-full rounded-sm border border-gray-300 p-2 text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" placeholder="Masukkan nomor hp...">
                </div>
                @error('no_hp')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="w-full">
                <button type="submit" class="w-full bg-green-500 p-2 font-semibold text-white">Tambahkan</button>
            </div>
        </form>
    </section>
</x-layouts.admin>
