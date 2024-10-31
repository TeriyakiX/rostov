<main class="page">
    <section class="brands">
        <div class="brands__container">
            <div class="brands__content">
                <div class="catalogContainer" id="video-container">
                    @foreach($VideoYoutube as $index => $solution)
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
                    @endforeach
                </div>
{{--                <div class="addBox">--}}
{{--                    @if(count($VideoYoutube) > 8)--}}
{{--                        <div class="add gallery__add" id="load-more" role="button" tabindex="0">Показать ещё</div>--}}
{{--                    @endif--}}
{{--                </div>--}}

                <div style="margin-top: 20px">
                    @include('layouts.pagination')
                    {{ $VideoYoutube->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </section>
</main>

<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const videos = document.querySelectorAll('#video-container > *');
    //     const loadMoreBtn = document.getElementById('load-more');
    //     const productsToShow = 8;
    //
    //     videos.forEach((video, index) => {
    //         if (index >= productsToShow) {
    //             video.style.display = 'none';
    //         }
    //     });
    //
    //     if (loadMoreBtn) {
    //         loadMoreBtn.addEventListener('click', function () {
    //             videos.forEach((video, index) => {
    //                 if (index >= productsToShow) {
    //                     video.style.display = 'block';
    //                 }
    //             });
    //             loadMoreBtn.style.display = 'none';
    //         });
    //     }
    // });
</script>
<style>
    .catalogTitle {
        -webkit-line-clamp: 4;
    }
</style>
