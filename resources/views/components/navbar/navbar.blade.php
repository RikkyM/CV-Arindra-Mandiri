<header class="sticky top-0 z-50 w-full bg-[#FAFAFA] shadow-sm md:container md:relative">
    <nav class="z-50 flex h-auto p-2 md:grid md:grid-cols-4 md:grid-rows-2 md:px-5 lg:grid-rows-1 lg:gap-10 lg:px-2">
        <div
            class="flex items-center justify-center gap-2 px-2 md:col-span-2 md:items-center md:justify-start lg:col-span-1 lg:items-start lg:justify-start">
            <a href="{{ route('home') }}" class="hidden font-bold md:inline md:text-2xl">Logo</a>
            <button class="block md:hidden">Menu</button>
            <a href="{{ route('login') }}" class="flex size-max flex-col items-center uppercase md:hidden">
                <svg class="size-7 md:size-7 xl:size-9" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16 5c-3.855 0-7 3.145-7 7c0 2.41 1.23 4.55 3.094 5.813C8.527 19.343 6 22.883 6 27h2c0-4.43 3.57-8 8-8s8 3.57 8 8h2c0-4.117-2.527-7.656-6.094-9.188A7.024 7.024 0 0 0 23 12c0-3.855-3.145-7-7-7zm0 2c2.773 0 5 2.227 5 5s-2.227 5-5 5s-5-2.227-5-5s2.227-5 5-5z"
                        fill="currentColor" />
                </svg>
                <span class="hidden text-xs font-bold">akun</span>
            </a>
        </div>
        <div
            class="flex w-full flex-col gap-3 md:col-span-4 md:row-start-2 md:py-1.5 lg:col-span-2 lg:col-start-2 lg:row-start-1 lg:p-0">
            <label for="search" class="flex h-9 w-full items-center justify-center">
                <input type="search" id="search"
                    class="h-full w-full border-y border-l border-black/20 p-2 text-xs outline-none placeholder:text-xs placeholder:font-semibold md:text-sm md:placeholder:text-sm"
                    placeholder="Cari apa saja disini...">
                <button class="flex size-9 items-center justify-center bg-[#F47B29]">
                    <svg class="size-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke="currentColor" strokeWidth="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20l-3-3" strokeLinecap="round" />
                        </g>
                    </svg>
                </button>
            </label>
            <ul class="flex hidden justify-center text-sm *:font-semibold *:capitalize md:flex md:gap-7 lg:gap-10">
                <li><a href="#">kategori produk</a></li>
                <li><a href="#">promo</a></li>
                <li><a href="#">produk lokal</a></li>
            </ul>
        </div>
        <x-navbar.nav-list />
    </nav>
</header>
