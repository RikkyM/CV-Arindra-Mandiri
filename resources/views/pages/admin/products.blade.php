<x-layouts.admin title="Products">
    <form action="{{ route('products') }}" method="POST" class="max-w-sm bg-white p-3 mb-3 flex flex-col gap-3 border border-gray-300">
        @csrf
        <h1 class="text-2xl font-semibold">Tambah Produk</h1>
        <label for="nama_produk" class="flex flex-col">
            <span>Nama Produk</span>
            <input type="text" id="nama_produk" name="nama_produk" class="p-2 text-sm border border-gray-300 rounded-sm" placeholder="Nama produk">
        </label>
        <label for="stok" class="flex flex-col">
            <span>Stok</span>
            <input type="number" id="stok" name="stok" max="999" maxlength="3" class="p-2 text-sm border border-gray-300 rounded-sm" placeholder="Stok produk">
        </label>
        <label for="harga" class="flex flex-col">
            <span>Harga</span>
            <input type="number" id="harga" name="harga" maxlength="3" class="p-2 text-sm border border-gray-300 rounded-sm" placeholder="Harga Produk">
        </label>
        <div class="w-full">
            <button type="submit" class="bg-green-500 w-full p-2 font-semibold text-white">Tambahkan</button>
        </div>
    </form>
    <table class="h-max w-full bg-white">
        <thead class="bg-black text-white">
            <tr class="text-left *:py-3">
                <th class="text-center">No.</th>
                <th>Nama Produk</th>
                <th>Stok</th>
                <th>Harga</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="text-left *:py-2">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="capitalize">{{ $product->nama_product }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="capitalize">Rp. {{ $product->price }}</td>
                    {{-- <td class="flex flex-col">
                        <a href="{{ route('users.activate', ['id' => $product->id]) }}"
                            class="text-green-500">Aktifkan</a>
                        <a href="{{ route('users.deactivate', ['id' => $product->id]) }}"
                            class="text-red-500">Nonaktifkan</a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.admin>
