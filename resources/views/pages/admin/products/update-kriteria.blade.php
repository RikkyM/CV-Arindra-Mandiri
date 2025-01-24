<x-layouts.admin title="Kriteria">
    <section class="flex h-[calc(100%_-_1rem)] flex-col items-center ">
        <form action="{{ route('update-kriteria', ['id' => $product->id]) }}" method="POST"
            class="mx-auto flex w-full flex-col gap-6 rounded-lg border border-gray-300 bg-white p-5 shadow-md">
            @csrf
            <h1 class="text-center text-2xl font-semibold">Update Kriteria</h1>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($discounts as $index => $discount)
                    <div class="rounded-lg border bg-gray-50 p-4 shadow-sm">
                        <h2 class="mb-3 text-center text-lg font-bold">Set {{ $loop->iteration }}</h2>

                        <label for="discounts_{{ $index }}_min_qty" class="flex flex-col">
                            <span class="text-sm">Minimum Quantity</span>
                            <input type="number" id="discounts_{{ $index }}_min_qty"
                                name="discounts[{{ $index }}][min_qty]" value="{{ $discount->min_qty }}"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                            @error("discounts.$index.min_qty")
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label for="discounts_{{ $index }}_max_qty" class="mt-3 flex flex-col">
                            <span class="text-sm">Maximum Quantity</span>
                            <input type="number" id="discounts_{{ $index }}_max_qty"
                                name="discounts[{{ $index }}][max_qty]" value="{{ $discount->max_qty }}"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                            @error("discounts.$index.max_qty")
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label for="discounts_{{ $index }}_percent_discount" class="mt-3 flex flex-col">
                            <span class="text-sm">Discount (%)</span>
                            <input type="number" id="discounts_{{ $index }}_percent_discount"
                                name="discounts[{{ $index }}][percent_discount]"
                                value="{{ $discount->persentase_diskon * 100 }}"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                            @error("discounts.$index.percent_discount")
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <label for="discounts_{{ $index }}_user_role" class="mt-3 flex flex-col">
                            <span class="text-sm">User Role</span>
                            <select id="discounts_{{ $index }}_user_role"
                                name="discounts[{{ $index }}][user_role]"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                                <option value="">-- Pilih --</option>
                                <option value="toko" {{ $discount->user_role == 'toko' ? 'selected' : '' }}>Toko
                                </option>
                                <option value="konsumen" {{ $discount->user_role == 'konsumen' ? 'selected' : '' }}>
                                    Konsumen</option>
                            </select>
                        </label>
                    </div>
                @endforeach

                @for ($i = count($discounts); $i < 10; $i++)
                    <div class="rounded-lg border bg-gray-50 p-4 shadow-sm">
                        <h2 class="mb-3 text-center text-lg font-bold">Set {{ $i + 1 }}</h2>

                        <label for="discounts_{{ $i }}_min_qty" class="flex flex-col">
                            <span class="text-sm">Minimum Quantity</span>
                            <input type="number" id="discounts_{{ $i }}_min_qty"
                                name="discounts[{{ $i }}][min_qty]"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                        </label>

                        <label for="discounts_{{ $i }}_max_qty" class="mt-3 flex flex-col">
                            <span class="text-sm">Maximum Quantity</span>
                            <input type="number" id="discounts_{{ $i }}_max_qty"
                                name="discounts[{{ $i }}][max_qty]"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                        </label>

                        <label for="discounts_{{ $i }}_percent_discount" class="mt-3 flex flex-col">
                            <span class="text-sm">Discount (%)</span>
                            <input type="number" id="discounts_{{ $i }}_percent_discount"
                                name="discounts[{{ $i }}][percent_discount]"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                        </label>

                        <label for="discounts_{{ $i }}_user_role" class="mt-3 flex flex-col">
                            <span class="text-sm">User Role</span>
                            <select id="discounts_{{ $i }}_user_role"
                                name="discounts[{{ $i }}][user_role]"
                                class="rounded-sm border border-gray-300 p-2 text-sm">
                                <option value="">-- Pilih --</option>
                                <option value="toko">Toko</option>
                                <option value="konsumen">Konsumen</option>
                            </select>
                        </label>
                    </div>
                @endfor
            </div>

            <div class="w-full">
                <button type="submit"
                    class="w-full rounded-lg bg-green-500 p-3 font-semibold text-white hover:bg-green-600">
                    Perbarui
                </button>
            </div>
        </form>
    </section>
</x-layouts.admin>
