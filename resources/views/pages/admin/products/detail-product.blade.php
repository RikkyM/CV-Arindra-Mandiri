<x-layouts.admin title="Kriteria">
    <section class="flex h-[calc(100%_-_1rem)] flex-col">
        <p class="capitalize">Nama Barang: {{ $product->nama_product }} {{ $product->varian->variant }}</p>
        <p>Stock: {{ $product->varian->stock }}</p>
        <p>Weight: {{ $product->varian->weight }}</p>
        <p>Exc PPN: Rp. {{ number_format($product->varian->exc_ppn, 0) }}</p>
        <p>Inc PPN: Rp. {{ number_format($product->varian->inc_ppn, 0) }}</p>
        <div class="border-gray-300 py-3">
            <h2 class="text-2xl font-bold capitalize border-b border-gray-300">Kriteria</h2>
            @foreach ($kriteria as $index => $krit)
                <div class="py-3">
                    <h2 class="font-semibold">Kriteria Ke {{ $index + 1 }}</h2>
                    <p>Pembelian: {{ $krit->min_qty }}{{ $krit->max_qty !== null ? '-' . $krit->max_qty : '++' }}</p>

                    <p>Discount (%): {{ $krit->persentase_diskon * 100 }}%</p>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.admin>
