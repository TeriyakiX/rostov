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
                                                                 href="#">{{$solution['title']}}</a>
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
<!-- Fonts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Styles -->
