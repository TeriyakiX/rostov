<main class="page">
        <section class="brands">
        <div class="brands__container _container">
            <div class="brands__content">
                <div class="brands__body">
				
                    @forelse($VideoYoutube as $solution)
                        <div class="brands__cardWrp">
                            <div class="brands__card">
                                <div class="brands__imgBox ibg"><a class="brands__imgLink"
                                                                   href="{{route('index.video.index', $solution['id'])}}">
                                        <picture>
                                            <source type="image/webp"
                                                    srcset="{{ asset('upload_images/' . $solution['image']) }}">
                                            <img src="{{ asset('upload_images/' . $solution['image']) }}" alt="#image">
                                        </picture>
                                    </a></div>
                                <div class="brands__cardBody"><a class="brands__cardTitle link"
                                                                 href="{{route('index.video.index', $solution['id'])}}">{{$solution['title']}}</a>
                                </div>
                            </div>
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
