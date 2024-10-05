<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
{{--                <div style="background-color: white">--}}
{{--                    <img src="http://mkrostov.ru/img/logo.webp" class="logo" alt="Laravel Logo">--}}
{{--                </div>--}}
                <div class="menu__logoBox"><a class="menu__logoLink" href="#">
                        <picture>
                            <source type="image/webp" srcset="{{ asset('/img/logo.webp') }}">
                            <img src="http://mkrostov.ru/img/logo.webp" class="logo" alt="Laravel Logo">
                        </picture>
                    </a></div>
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
