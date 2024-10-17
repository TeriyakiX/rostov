<main class="page">
        <section class="brands">
        <div class="brands__container">
            <div class="brands__content">
                <div class="catalogContainer">
                    @forelse($VideoYoutube as $index => $solution)
                        <div class="catalogItemBoxWrp">
                            <a class="catalogItemBox {{ $index % 2 == 0 ? 'catalogItemBox--left' : 'catalogItemBox--right' }}"
                               href="{{route('index.video.index', $solution['id'])}}">
                                <div class="catalogItemContent">
                                    <div class="catalogTitle">{{$solution['title']}}</div>
                                </div>
                                <div class="catalogItemImgBox block-{{$loop->index}}">
                                    <div class="catalogItemImg" style="background-image: url({{ asset('upload_images/' . $solution['image']) }})">

                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div>Empty</div>
                    @endforelse
                </div>

            </div>

        </div>
    </section>
</main>
@include('layouts.pagination')
