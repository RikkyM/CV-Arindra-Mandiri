<x-layouts.admin title="Tambah Produk">
    <section class="mx-auto flex h-full max-w-screen-sm items-center justify-center">
        <form action="{{ route('add-product') }}" method="POST" enctype="multipart/form-data"
            class="mb-3 flex w-full max-w-xs flex-col gap-3 border border-gray-300 bg-white p-3">
            @csrf
            <h1 class="text-2xl font-semibold">Tambah Produk</h1>
            <label for="nama_produk" class="flex flex-col">
                <span class="text-sm">Nama Produk</span>
                <input type="text" id="nama_produk" name="nama_produk"
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Nama produk">
                @error('nama_produk')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="product_name">
                <select name="product_name" id="product_name"
                    class="w-full rounded-sm border border-gray-300 p-2 text-sm capitalize">
                    <option value="">-- Pilih --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->nama_product }}">{{ $product->nama_product }}</option>
                    @endforeach
                </select>
                @error('product_name')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="my-3 border border-gray-300"></div>
            <label for="image" class="flex flex-col">
                <span class="text-sm">Product Image <span class="text-red-500">*</span></span>
                <input type="file" id="image" name="image" accept="image/*" required
                    class="rounded-sm border border-gray-300 p-2 text-sm">
                @error('image')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="variant" class="flex flex-col">
                <span class="text-sm">Variant</span>
                <input type="text" id="variant" name="variant"
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Variant">
                @error('variant')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="stock" class="flex flex-col">
                <span class="text-sm">Stock</span>
                <input type="number" id="stock" name="stock" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Stock">
                @error('stock')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="flex flex-col">
                <label for="weight" class="text-sm">Weight</label>
                <div class="flex w-full">
                    <input type="text" id="weight" name="weight" required
                        class="flex-1 rounded-sm border border-gray-300 p-2 text-sm" placeholder="Weight">
                    <label for="weight_unit" class="h-full">
                        <select name="weight_unit" id="weight_unit" required
                            class="w-full rounded-sm border border-gray-300 p-2 text-sm">
                            <option value="">-- Pilih --</option>
                            <option value="GR">GR</option>
                            <option value="KG">KG</option>
                            <option value="JAR">JAR</option>
                            <option value="PAIL">PAIL</option>
                        </select>
                    </label>
                </div>
                @error('weight')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <label for="exc_ppn" class="flex flex-col">
                <span class="text-sm">Exc PPN</span>
                <input type="number" id="exc_ppn" name="exc_ppn" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Exc PPN">
                @error('exc_ppn')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>
            <label for="inc_ppn" class="flex flex-col">
                <span class="text-sm">Inc PPN</span>
                <input type="number" id="inc_ppn" name="inc_ppn" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" placeholder="Inc PPN">
                @error('inc_ppn')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="w-full">
                <button type="submit" class="w-full bg-green-500 p-2 font-semibold text-white">Tambahkan</button>
            </div>
        </form>
    </section>
</x-layouts.admin>
