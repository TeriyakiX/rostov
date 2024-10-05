
<div class="gallery__itemWrp">
    <div class="gallery__itemBox">
        <a class="gallery__imgBox ibg" href="{{ route('index.projects.show', ['slug' => $project->slug]) }}">
            <picture>
                <source type="image/webp" srcset="{{ $project->photos->first() ? url('/upload_images/' . $project->photos->first()->path) : null }}">
                <img src="{{ $project->photos->first() ? url('/upload_images/' . $project->photos->first()->path) : null }}" alt="g1">
            </picture>
        </a>
        <div class="gallery__itemTitle">
            <a class="link" href="{{ route('index.projects.show', ['slug' => $project->slug]) }}">
                {{ $project->title }}
            </a>
        </div>
{{--        <ul class="gallery__params">--}}
{{--            <li class="gallery__params">Ростов-на-Дону</li>--}}
{{--        </ul>--}}
    </div>
</div>
