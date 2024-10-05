<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="search-container">
    <form action="#" class="formSearch">
        <input class="inputSearch" type="text" name="search"  data-value="{{ request()->get('search') ?: 'Поиск по справочнику' }}"
               value="{{ request()->get('search') }}" >
        <button type="submit" class="btn searchBtn">Найти</button>
    </form>
</div>

<div class="searchLetter">
    @foreach($words as $letter => $letterGroup)
        <a class="findLetter link" id="{{$letter}}">{{ $letter }}
        </a>
    @endforeach
</div>
@foreach($words as $letter => $letterGroup)
    <div style="display: flex;min-height: 100px">
        <div class="letterName" id="{{$letter}}">{{ $letter }}
        </div>
        <div class="border">
        </div>
    </div>
    <div class="wordsGroup">
        @foreach($letterGroup as $letter)

            <a class="link letter" href="{{route('index.posts.word',['word'=>$letter->slug])}}">{{ $letter->title }}</a>

        @endforeach
    </div>

@endforeach
<script>
    $(document).ready(function () {
            $('.findLetter').click(function (event) {
                let currentId = event.target.id;
                $('.letterName#' + currentId)[0].scrollIntoView({
                    behavior: "smooth", // or "auto" or "instant"
                    block: "center" // or "end"
                });
            });
        }
    )
</script>
<style>
    .searchBtn{
        border-radius: 0!important;

    }
    .search-container {
        margin-bottom: 20px;

        border-right: 0;
        border-radius: 1px;
        margin-left: auto;
        margin-right: auto;

        height: 40px;
    }

    .formSearch {
        justify-content: space-between;
        display: flex;

    }

    .inputSearch {
        border: 1px solid rgba(80, 80, 80, 0.51); /* Параметры границы */
        flex: 1;
        padding-left: 20px;
        width: 80%;
        border-right: none;
    }

    .findLetter {
        font-size: 30px;
        margin: 20px;
        text-transform: uppercase;
        border: 1px solid #e8ecef;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        text-align: center;
        vertical-align: baseline;
        padding-top: 6px;
    }

    @media (max-width: 1100px) {
        .findLetter {
            margin: 10px;
        }
    }

    .searchLetter {
        display: flex;
        flex-direction: row;

        flex-wrap: wrap;
    }

    .wordsGroup {
        min-height: 100px;
        display: flex;
        border-top: 1px solid #e8ecef;
        margin-left: 70px;
        margin-top: -75px;
        flex-direction: row;
        flex-wrap: wrap;

    }


    .letterName {
        TEXT-TRANSFORM: UPPERCASE;
        font-size: 44px;
        color: #006bde;


        background: #f5f8fb;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        text-align: center; /* выравнять текст по середине по горизонтали */

    }


    .letter {
        text-transform: lowercase;
        min-width: 20%;
        padding: 10px;
        font-size: 16px;
    }
</style>
