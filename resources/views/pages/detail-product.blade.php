<x-components.layouts.users title="{{ $product->nama_product }}">
    <section class="container mx-auto mt-5 flex gap-8 bg-white px-5">
        <div class="flex aspect-square w-72 items-center justify-center bg-white border border-black">
            Gambar {{ $product->nama_product }}
        </div>
        <form action="{{ route('detail_product', ['id' => $product->id]) }}" method="POST"
            class="flex flex-1 flex-col justify-between">
            @csrf
            <h2 class="text-3xl font-bold capitalize">{{ $product->nama_product }}</h2>
            <div class="flex max-w-xs flex-col gap-3">
                <h2 class="text-3xl font-bold capitalize">Rp. {{ $product->price }}</h2>
                <div class="flex items-center gap-5">
                    <label for="qty">
                        <input type="number" name="qty" id="qty" value="1"
                            class="w-[7ch] p-2.5 text-center border border-gray-400">
                    </label>
                    <button type="submit" class="w-full bg-green-500 p-3 text-white text-lg font-bold">Beli</button>
                </div>
            </div>
        </form>
    </section>
</x-components.layouts.users>
