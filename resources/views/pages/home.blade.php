<x-components.layouts.users title="Toko Bahan Kue">
    <div class="flex h-[26rem] items-center justify-center bg-black text-white">
        <span>Slider</span>
    </div>
    <section class="container mx-auto mt-5 space-y-5 px-5">
        <div>
            <div class="relative flex h-16 items-center justify-between border-b-2">
                <h4
                    class="relative flex h-full w-max items-center justify-center text-sm font-semibold capitalize italic leading-[4rem] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-gray-300 after:content-[''] md:text-lg">
                    official store brand</h4>
                <a href="#" class="inline-block h-max border border-gray-300 px-2 py-2 text-sm uppercase">lihat
                    semua</a>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3 md:grid-cols-3 lg:grid-cols-5">
                @for ($i = 0; $i < 10; $i++)
                    <a href="#"
                        class="{{ $i >= 6 ? 'hidden lg:flex' : '' }} flex aspect-square items-center justify-center bg-white">
                        Logo {{ $i + 1 }}
                    </a>
                @endfor
            </div>
        </div>
        <div>
            <div class="relative flex h-16 items-center justify-between border-b-2">
                <h4
                    class="relative flex h-full w-max items-center justify-center text-sm font-semibold capitalize italic leading-[4rem] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-gray-300 after:content-[''] md:text-lg">
                    kategori terpopuler</h4>
            </div>
            <div class="grid grid-cols-3 grid-rows-2 gap-4 py-3 md:grid-cols-3 lg:grid-cols-6">
                @for ($i = 0; $i < 6; $i++)
                    <a href="#"
                        class="{{ $i >= 3 ? 'hidden lg:flex' : '' }} flex aspect-square items-center justify-center bg-white">
                        Gambar {{ $i + 1 }}
                    </a>
                @endfor
                <a href="#"
                    class="col-span-3 flex w-full items-center justify-center bg-white capitalize md:col-span-3 lg:col-span-6">
                    shipping policy
                </a>
            </div>
        </div>
        <div>
            <div class="relative flex h-16 items-center justify-between border-b-2">
                <h4
                    class="relative flex h-full w-max items-center justify-center text-sm font-semibold capitalize italic leading-[4rem] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-gray-300 after:content-[''] md:text-lg">
                    produk unggulan</h4>
            </div>
            <div class="grid grid-cols-3 grid-rows-1 gap-4 py-3 lg:grid-cols-6">
                @foreach ($products as $index => $product)
                    <div class="border bg-white shadow-md border-gray-300">
                        <a href="{{ route('detail_product', ['id' => $product->id]) }}"
                            class="group relative flex aspect-square overflow-hidden shadow-sm transition-shadow hover:shadow-md">
                            @if ($product->product->gambar_product)
                                <img class="h-full w-full object-fill transition-transform duration-300 group-hover:scale-105"
                                    src="{{ route('image.show', $product->product->gambar_product) }}"
                                    alt="{{ $product->product->nama_product }}">
                            @endif
                        </a>
                        <div class="flex flex-col gap-3 p-2.5 mb-5">
                            <div class="flex flex-col">
                                <a href="{{ route('detail_product', ['id' => $product->id]) }}"
                                    class="text-xl font-bold uppercase hover:text-[#F47B29] flex w-max">
                                    {{ $product->product->nama_product }}
                                </a>
                                <p class="text-sm font-semibold">{{ $product->weight }}</p>
                            </div>
                            <p class="font-bold text-xl">Rp. {{ number_format($product->inc_ppn, 0, ',', '.') }}</p>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
        <div>
            <div class="relative flex h-16 items-center justify-between border-b-2">
                <h4
                    class="relative flex h-full w-max items-center justify-center text-sm font-semibold capitalize italic leading-[4rem] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-gray-300 after:content-[''] md:text-lg">
                    produk terbaru</h4>
                <a href="#" class="inline-block h-max border border-gray-300 px-2 py-2 text-sm uppercase">lihat
                    semua</a>
            </div>
            <div class="grid grid-cols-3 grid-rows-1 gap-4 py-3 lg:grid-cols-5">
                @for ($i = 0; $i < 5; $i++)
                    <a href="#"
                        class="{{ $i >= 3 ? 'hidden lg:flex' : '' }} flex aspect-square items-center justify-center bg-white">
                        Gambar Produk {{ $i + 1 }}
                    </a>
                @endfor
            </div>
        </div>
    </section>
</x-components.layouts.users>
