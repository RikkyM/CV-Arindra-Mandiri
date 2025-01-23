<li>
    <a href="{{ $url ?? '#' }}" class="{{ $class ?? '' }} flex size-max flex-col items-center uppercase">
        {{ $slot }}
        <span class="hidden text-xs font-bold md:inline">{{ $text ?? '' }}</span>
    </a>
</li>