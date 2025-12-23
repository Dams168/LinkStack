<div class="fadein w-full">
    <span class="text-sm font-medium">
                {{ $link->title }}
            </span>
        <div class="relative w-full overflow-hidden rounded-xl aspect-video">
            <iframe
                class="absolute inset-0 h-full w-full"
                src="{{ $link->link }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                loading="lazy">
            </iframe>
        </div>
</div>
