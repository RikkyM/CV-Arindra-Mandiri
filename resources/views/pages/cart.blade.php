<x-components.layouts.users title="Cart">
    <section class="container mx-auto mt-5 flex gap-8 px-5">
        <div class="flex flex-1 flex-col gap-5">
            @if ($details->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-md bg-gray-100 p-10 text-center">
                    <h2 class="text-3xl font-bold text-gray-500">Keranjang Anda kosong</h2>
                    <p class="mt-3 text-gray-400">Tambahkan produk ke keranjang untuk melanjutkan.</p>
                </div>
            @else
                <form id="cart-form" class="space-y-5">
                    @foreach ($details as $item)
                        <div class="flex h-56 max-h-56 w-full bg-white">
                            <div
                                class="flex aspect-square h-full items-center justify-center border border-black text-2xl font-semibold">
                                Gambar</div>
                            <div class="flex w-full justify-between px-5 py-4">
                                <div class="flex w-max flex-col justify-between gap-2">
                                    <p class="text-2xl font-bold capitalize">{{ $item->product->nama_product }}</p>
                                    <div class="flex w-full items-center gap-10">
                                        <p class="font-semibold">Qty: {{ $item->qty }}</p>
                                        <p class="font-bold">Rp. {{ $item->price }}</p>
                                    </div>
                                </div>
                                <p class="text-2xl font-bold">Rp. {{ $item->subtotal }}</p>
                            </div>
                            <input type="hidden" name="product[]" value="{{ $item->product->nama_product }}">
                            <input type="hidden" name="qty[]" value="{{ $item->qty }}">
                            <input type="hidden" name="price[]" value="{{ $item->price }}">
                            <input type="hidden" name="subtotal[]" value="{{ $item->subtotal }}">
                        </div>
                    @endforeach
                    <input type="hidden" name="nama" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="total" value="{{ $cart->total }}">
                </form>
            @endif
        </div>
        <div class="flex h-auto max-h-[500px] w-72 flex-col justify-between bg-gray-300 p-5 shadow-sm">
            <h1 class="bg-gray-500 px-3 py-5 text-left text-2xl font-bold uppercase text-gray-300">ringkasan</h1>
            <div class="py-5 text-center text-lg font-bold">
                <p>Gratis Pengiriman di atas</p>
                <p>Rp. 10.000.000</p>
                <p class="text-sm text-gray-500">(khusus JABODETABEK)</p>
            </div>
            <div class="mt-5 flex justify-between px-5">
                <p>Subtotal: </p>
                <p>Rp. {{ $cart->total }}</p>
            </div>
            <div class="mt-16 flex justify-between px-5 font-bold">
                <p>Grand Total: </p>
                <p>Rp. {{ $cart->total }}</p>
            </div>
            <button type="button" onclick="sendToWhatsApp()"
                class="mt-4 rounded-sm bg-green-500 p-4 text-xl font-bold text-white">Kirim ke WhatsApp</button>
        </div>
    </section>

    <script>
        function sendToWhatsApp() {
            const form = document.getElementById('cart-form');
            const formData = new FormData(form);

            const nama = formData.getAll('nama');
            const products = formData.getAll('product[]');
            const qtys = formData.getAll('qty[]');
            const prices = formData.getAll('price[]');
            const subtotals = formData.getAll('subtotal[]');
            const total = formData.get('total');

            let message = "*Nota Belanja*\n";
            message += `*Nama: ${nama}*\n`;
            message += "---------------------------------------\n";
            for (let i = 0; i < products.length; i++) {
                message +=
                    `- *${products[i]}*\n  *Qty:* ${qtys[i]}\n  *Harga:* Rp. ${prices[i]}\n  *Subtotal:* Rp. ${subtotals[i]}\n\n`;
            }

            message += "---------------------------------------\n";

            message += `*Total: Rp. ${total}*\n\n`;
            message += "_Terima kasih telah berbelanja di toko kami!_";

            const phoneNumber = "6289690795500";

            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

            window.open(whatsappUrl, '_blank');
        }
    </script>
</x-components.layouts.users>
