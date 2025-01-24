<x-layouts.admin title="Products">
    <a href="{{ route('add-product') }}" class="my-5 block w-max rounded-sm bg-green-500 p-2 font-bold text-white">Tambah
        Produk</a>
    <table class="h-max w-full bg-white">
        <thead class="bg-black text-white">
            <tr class="text-left *:py-3">
                <th class="text-center">No.</th>
                <th>Nama Produk</th>
                <th>Exc PPN</th>
                <th>Inc PPN</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Kriteria</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="text-left *:py-5 even:bg-gray-200 hover:bg-gray-300">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="capitalize">{{ $product->product->nama_product }} {{ $product->variant }}</td>
                    <td class="capitalize">Rp. {{ $product->exc_ppn }}</td>
                    <td class="capitalize">Rp. {{ $product->inc_ppn }}</td>
                    <td class="text-center">{{ $product->stock }}</td>
                    <td class="text-center">
                        <a href="#" class="text-green-500 mr-1">Detail</a>
                        <a href="{{ route('update-kriteria', ['id' => $product->id]) }}" class="text-yellow-500 ml-1">Update</a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="rounded-md bg-blue-500 p-2 font-semibold text-white">Edit</a>
                        <a href="#" class="rounded-md bg-green-500 p-2 font-semibold text-white">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.admin>
