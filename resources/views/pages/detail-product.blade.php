<x-components.layouts.users title="{{ $product->product->nama_product }}">
    <section class="container mx-auto mt-5 flex gap-8 bg-white px-5">
        {{-- {{ route('product.image', ['id' => $product->product->id]) }} --}}
        <img src="{{ route('image.show', $product->product->gambar_product) }}" class="flex aspect-square w-72 items-center justify-center bg-white border border-black"/>
        <form action="{{ route('detail_product', ['id' => $product->id]) }}" method="POST"
            class="flex flex-1 flex-col justify-between">
            @csrf
            <h2 class="text-3xl font-bold capitalize">{{ $product->product->nama_product }} {{ $product->variant }}</h2>
            <div class="flex max-w-xs flex-col gap-3">
                <h2 class="text-3xl font-bold capitalize">Rp. {{ number_format($product->inc_ppn, 0, ',', '.') }}</h2>
                <div class="flex items-center gap-5">
                    <div class="flex items-center border border-gray-400">
                        <button type="button" onclick="decrementQty()" class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200">-</button>
                        <input type="number" name="qty" id="qty" value="1" min="1"
                            class="w-[7ch] p-2.5 text-center border-x border-gray-400 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                            readonly>
                        <button type="button" onclick="incrementQty()" class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200">+</button>
                    </div>
                    <button type="submit" class="w-full bg-green-500 p-3 text-white text-lg font-bold">Beli</button>
                </div>
            </div>
        </form>
    </section>

    <script>
        function incrementQty() {
            const qtyInput = document.getElementById('qty');
            qtyInput.value = parseInt(qtyInput.value) + 1;
        }

        function decrementQty() {
            const qtyInput = document.getElementById('qty');
            const currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        }
    </script>
</x-components.layouts.users>