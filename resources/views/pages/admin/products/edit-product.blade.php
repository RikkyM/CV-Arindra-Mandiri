<!-- pages/admin/products/edit-product.blade.php -->
<x-layouts.admin title="Edit Produk">
    <section class="mx-auto flex h-full max-w-screen-sm items-center justify-center">
        <form action="{{ route('update-product', $productVariant->id) }}" method="POST"
            class="mb-3 flex w-full max-w-xs flex-col gap-3 border border-gray-300 bg-white p-3">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-semibold">Edit Produk</h1>
            
            <label for="nama_produk" class="flex flex-col">
                <span class="text-sm">Nama Produk</span>
                <input type="text" id="nama_produk" name="nama_produk"
                    class="rounded-sm border border-gray-300 p-2 text-sm" 
                    value="{{ $productVariant->product->nama_product }}"
                    placeholder="Nama produk">
                @error('nama_produk')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="variant" class="flex flex-col">
                <span class="text-sm">Variant</span>
                <input type="text" id="variant" name="variant"
                    class="rounded-sm border border-gray-300 p-2 text-sm" 
                    value="{{ $productVariant->variant }}"
                    placeholder="Variant">
                @error('variant')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="stock" class="flex flex-col">
                <span class="text-sm">Stock</span>
                <input type="number" id="stock" name="stock" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" 
                    value="{{ $productVariant->stock }}"
                    placeholder="Stock">
                @error('stock')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="flex flex-col">
                <label for="weight" class="text-sm">Weight</label>
                <div class="flex w-full">
                    @php
                        $weightParts = explode(' ', $productVariant->weight);
                        $weightValue = $weightParts[0];
                        $weightUnit = $weightParts[1] ?? '';
                    @endphp
                    <input type="text" id="weight" name="weight" required
                        class="flex-1 rounded-sm border border-gray-300 p-2 text-sm" 
                        value="{{ $weightValue }}"
                        placeholder="Weight">
                    <label for="weight_unit" class="h-full">
                        <select name="weight_unit" id="weight_unit" required
                            class="w-full rounded-sm border border-gray-300 p-2 text-sm">
                            <option value="">-- Pilih --</option>
                            <option value="GR" {{ $weightUnit == 'GR' ? 'selected' : '' }}>GR</option>
                            <option value="KG" {{ $weightUnit == 'KG' ? 'selected' : '' }}>KG</option>
                            <option value="JAR" {{ $weightUnit == 'JAR' ? 'selected' : '' }}>JAR</option>
                            <option value="PAIL" {{ $weightUnit == 'PAIL' ? 'selected' : '' }}>PAIL</option>
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
                    class="rounded-sm border border-gray-300 p-2 text-sm" 
                    value="{{ $productVariant->exc_ppn }}"
                    placeholder="Exc PPN">
                @error('exc_ppn')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <label for="inc_ppn" class="flex flex-col">
                <span class="text-sm">Inc PPN</span>
                <input type="number" id="inc_ppn" name="inc_ppn" required
                    class="rounded-sm border border-gray-300 p-2 text-sm" 
                    value="{{ $productVariant->inc_ppn }}"
                    placeholder="Inc PPN">
                @error('inc_ppn')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </label>

            <div class="w-full">
                <button type="submit" class="w-full bg-green-500 p-2 font-semibold text-white">Update</button>
            </div>
        </form>
    </section>
</x-layouts.admin>