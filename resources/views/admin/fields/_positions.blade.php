<div class="col-12 col-md-12">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="container">
                        <div class="form-group">
                            <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>
                            @if($positions)
                                <table>
                                    <tbody>
                                    @foreach($positions as $position)
                                        <tr>
                                            <td>
                                                {{ $position->title }}:
                                            </td>

                                            <td>
                                                @php
                                                    $options = json_decode($position->pivot->options, true);
                                                   $keyMapping = [
                                                       'attribute_prices' => 'Цены атрибутов',
                                                       'startprice' => 'Стартовая цена',
                                                       'startpricepromo' => 'Стартовая цена (промо)',
                                                       'price' => 'Цена',
                                                       'select' => 'Выбор',
                                                       'color' => 'Цвет',
                                                       'quantity' => 'Количество',
                                                       'totalPrice' => 'Общая стоимость',
                                                       'width' => 'Ширина',
                                                       'attribute' => 'Атрибуты',
                                                       'totalSquare' => 'Общий квадрат',
                                                       'square' => 'Квадрат',
                                                       'length' => 'Длинна',
                                                   ];
                                                @endphp
{{--                                                {{$position->pivot->options}}--}}
                                                @foreach($options as $key => $value)
                                                    @if(is_array($value))
                                                        {{-- Предположим, мы просто преобразуем его в JSON строку --}}
                                                        {{ $keyMapping[$key] ?? $key }}: {{ json_encode($value) }}
                                                    @else
                                                        {{ $keyMapping[$key] ?? $key }}: {{ $value ? $value : '0' }}
                                                    @endif
                                                @endforeach

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
