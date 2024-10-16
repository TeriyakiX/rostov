<main class="page">
        <section class="brands">
        <div class="brands__container">
            <div class="brands__content">
                <div class="brands__content__tags">@include('posts.custom._tags')</div>
                <div class="catalogContainer">
                    @forelse($solutions as $index => $solution)
                        <div class="catalogItemBoxWrp">
                            <a href="{{route('index.solutions.index', $solution['id'])}}"
                               class="catalogItemBox {{ $index % 2 == 0 ? 'catalogItemBox--left' : 'catalogItemBox--right' }}">

                                <div class="catalogItemContent">
                                    <div class="catalogTitle">{{$solution['title']}}</div>
                                </div>

                                <div class="catalogItemImgBox block-{{$loop->index}}">
                                    <div class="catalogItemImg" style="background-image: url({{ asset('upload_images/' . $solution->photos[0]->path) }})">
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
            {{ $solutions->links('pagination::bootstrap-4') }}
    </section>
</main>
@include('layouts.pagination')

<style>
    @media (max-width: 767.98px) {
        .brands__content__tags {
            display: none;
        }
    }
</style>
