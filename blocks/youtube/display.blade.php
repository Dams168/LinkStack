{{-- call Endpoint clickNumber for analytic clicks --}}
<a href="{{ route('clickNumber', $link->id) }}" class="block">
    <div class="fadein w-full">
        {{-- For title URL --}}
        <span class="text-sm font-medium">
            {{ $link->title }}
        </span>

        {{-- Display video Base on URL --}}
        <div class="relative w-full overflow-hidden rounded-xl aspect-video pointer-events-none">
            <iframe
                class="absolute inset-0 h-full w-full"
                src="{{ $link->link }}"
                loading="lazy">
            </iframe>
        </div>
    </div>
</a>
