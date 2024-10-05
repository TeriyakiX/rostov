<section class="services">
    <div class="services__container _container">
        <div class="services__content">
            <h2 class="services__title t">Услуги для наших клиентов:</h2>
            <div class="services__body">
                @foreach($ourServices as $index=>$ourService)
                    <div class="services__itemWrp">
                        <div class="serviceCard services__card">
                            <div class="serviceCard__imgBox">
                                <a class="serviceCard__imgWrp" href="{{ route('index.posts.show', ['slug' => $ourService->slug]) }}">
                                    <picture>
                                        <img src="{{ asset('upload_images/' . $ourService->filepath) }}" alt="s1">
                                    </picture>
                                </a>
                            </div>
                            <div class="serviceCard__count">
                                0{{ $index+1 }}
                            </div>
                            <h3 class="serviceCard__title">
                                @if($ourService->slug != 'оплата')
                                <a class="link" href="{{ route('index.posts.show', ['slug' => $ourService->slug]) }}">
                                    {{ $ourService->title }}
                                </a>
                                @else
                                    <a class="link" href="{{ route('index.posts.show', ['slug' => 'oplata']) }}">
                                        {{ $ourService->title }}
                                    </a>
                                @endif
                            </h3>
                            <p class="serviceCard__txt">
                                {{ readmore_text($ourService->body) }}
                            </p>
                            @if($ourService->slug != 'оплата')
                                <a class="serviceCard__btn btn" href="{{ route('index.posts.show', ['slug' => $ourService->slug]) }}">
                                    Подробнее
                                </a>
                            @else
                                <a class="serviceCard__btn btn" href="{{ route('index.posts.show', ['slug' => 'oplata']) }}">
                                    Перейти к оплате
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


