<x-components.layouts.users title="Cart">
    <div class="container mx-auto mt-5 flex gap-8 px-5">
        @if (session('success'))
            <div class="rounded bg-green-500 p-2 font-semibold text-white">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded bg-red-500 p-2 font-semibold text-white">
                {{ session('error') }}
            </div>
        @endif
    </div>
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
                            <img src="{{ route('image.show', $item->product->gambar_product) }}"
                                class="flex aspect-square h-full items-center justify-center border border-black text-2xl font-semibold"/>
                            <div class="flex w-full justify-between px-5 py-4">
                                <div class="flex w-max flex-col justify-between gap-2">
                                    <p class="text-2xl font-bold capitalize">{{ $item->product->nama_product }}
                                        {{ $item->variant->variant }}</p>
                                    <div class="flex w-full items-center gap-10">
                                        <div class="flex items-center">
                                            <button type="button"
                                                class="decrement-btn rounded-l-md bg-gray-200 px-3 py-1">-</button>
                                            <input type="number" name="qty[]" value="{{ $item->qty }}"
                                                class="w-[5ch] border border-gray-300 text-center [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                readonly>
                                            <button type="button"
                                                class="increment-btn rounded-r-md bg-gray-200 px-3 py-1">+</button>
                                        </div>
                                        <p class="font-bold">Rp. {{ number_format($item->price, 0) }}</p>
                                    </div>
                                    @if ($item->discount > 0)
                                        <div class="text-red-500">
                                            <p>Diskon: {{ number_format($item->discount, 0) }}%</p>
                                            <p>Harga setelah diskon: Rp.
                                                {{ number_format($item->price_after_discount, 0) }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex h-full flex-col items-end justify-between px-2 pb-2">
                                    <p class="text-2xl font-bold">Rp.
                                        {{ number_format($item->subtotal_after_discount, 0) }}</p>
                                    <a href="{{ route('remove_from_cart', $item->id) }}"
                                        class="rounded bg-red-500 px-5 py-2 font-semibold text-white">
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product[]" value="{{ $item->product->nama_product }}">
                        <input type="hidden" name="qty[]" value="{{ $item->qty }}">
                        <input type="hidden" name="price[]" value="{{ $item->price }}">
                        <input type="hidden" name="subtotal[]" value="{{ $item->subtotal }}">
                        <input type="hidden" name="price_after_discount[]" value="{{ $item->price_after_discount }}">
                        <input type="hidden" name="discount[]" value="{{ $item->discount }}">
                    @endforeach
                    <input type="hidden" name="nama" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="total" value="{{ $grandTotal }}">
                </form>
            @endif
        </div>
        {{-- y --}}
        <div class="flex h-auto max-h-[500px] w-72 flex-col justify-between bg-gray-300 p-5 shadow-sm">
            <h1 class="bg-gray-500 px-3 py-5 text-left text-2xl font-bold uppercase text-gray-100">ringkasan</h1>
            <div class="py-5 text-center text-lg font-bold">
                <p>Gratis Pengiriman di atas</p>
                <p>Rp. 10.000.000</p>
                <p class="text-sm text-gray-500">(khusus SUMATERA SELATAN)</p>
            </div>
            <div class="mt-5 flex justify-between px-5">
                @if ($cart)
                    <p>Subtotal: </p>
                    <p>Rp. {{ number_format($cart->total, 0) }}</p>
                @endif
            </div>
            <div class="mt-16 flex justify-between px-5 font-bold">
                <p>Grand Total: </p>
                <p>Rp. {{ number_format($grandTotal, 0) }}</p>
            </div>

            <button type="button" onclick="sendToWhatsApp()"
                class="mt-4 rounded-sm bg-green-500 p-4 text-xl font-bold text-white">Kirim ke WhatsApp</button>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const incrementButtons = document.querySelectorAll('.increment-btn');
            const decrementButtons = document.querySelectorAll('.decrement-btn');

            incrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    let value = parseInt(input.value, 10);
                    value = isNaN(value) ? 0 : value;
                    value++;
                    input.value = value;
                });
            });

            decrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.nextElementSibling;
                    let value = parseInt(input.value, 10);
                    value = isNaN(value) ? 0 : value;
                    if (value > 1) {
                        value--;
                        input.value = value;
                    }
                });
            });
        });

        function sendToWhatsApp() {
            const form = document.getElementById('cart-form');
            const formData = new FormData(form);

            const nama = formData.get('nama');
            const products = formData.getAll('product[]');
            const qtys = formData.getAll('qty[]');
            const prices = formData.getAll('price[]');
            const subtotals = formData.getAll('subtotal[]');
            const priceAfterDiscounts = formData.getAll('price_after_discount[]');
            const discounts = formData.getAll('discount[]');
            const total = formData.get('total');

            let message = "*Nota Belanja*\n";
            message += `*Nama: ${nama}*\n`;
            message += "---------------------------------------\n";
            for (let i = 0; i < products.length; i++) {
                let itemMessage =
                    `- *${products[i]}*\n  *Qty:* ${qtys[i]}\n  *Harga:* Rp. ${prices[i]}\n  *Subtotal:* Rp. ${subtotals[i]}\n`;

                if (discounts[i] > 0) {
                    itemMessage +=
                        `  *Diskon:* ${discounts[i]}%\n  *Harga setelah diskon:* Rp. ${priceAfterDiscounts[i]}\n`;
                }

                message += itemMessage + "\n";
            }

            message += "---------------------------------------\n";
            message += `*Total: Rp. ${total}*\n\n`;
            message += "_Terima kasih telah berbelanja di toko kami!_";

            const phoneNumber = "6289690795500"; // Ganti dengan nomor WhatsApp tujuan
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

            window.open(whatsappUrl, '_blank');
        }
    </script>
</x-components.layouts.users>
