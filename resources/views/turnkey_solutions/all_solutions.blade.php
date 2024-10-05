<main class="page">
        <section class="brands">
        <div class="brands__container _container">
            <div class="brands__content">
                @include('posts.custom._tags')
                <div class="brands__body">

                    @forelse($solutions as $solution)
                        <div class="brands__cardWrp">
                            <div class="brands__card">
                                <div class="brands__imgBox ibg"><a class="brands__imgLink"
                                                                   href="{{route('index.solutions.index', $solution['id'])}}">
                                        <picture>
                                            <source type="image/webp"
                                                    srcset="{{ asset('upload_images/' . $solution->photos[0]->path) }}">
                                            <img src="{{ asset('upload_images/' . $solution->photos[0]->path) }}"
                                                 alt="#image">
                                        </picture>
                                    </a></div>
                                <div class="brands__cardBody"><a class="brands__cardTitle link"
                                href="{{route('index.solutions.index', $solution['id'])}}">{{$solution['title']}}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div>Empty</div>
                    @endforelse
                </div>

            </div>

        </div>
            {{ $solutions->links('pagination::bootstrap-4') }}
    </section>
</main>
@include('layouts.pagination')
