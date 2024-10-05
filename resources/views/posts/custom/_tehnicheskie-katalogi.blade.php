<style>
    @media screen and (max-width: 900px) {
        .prodCard__docsItem {
            flex: 0 0 100% !important;
        }

        .doc_type {
            font-size: smaller;
            word-break: initial;
        }
    }
    .prodCard__docsItem{
        flex: 0 0 21%; margin: 15px;
    }
</style>
<section class="documentation">
    <input type="hidden" id="doc_type_id" value="{{$id}}">
    <div style="display: flex; margin-bottom: 1%; font-size: 2rem; cursor: pointer">
        @foreach(\App\Models\DocumentType::all() as $doc_type)
        <div class="doc_type {{$doc_classes[$count]}}" id="{{$doc_type->id}}" style="margin-right: 20%; cursor: pointer; width: 30%">{{$doc_type->title}}</div>
{{--        <div class="doc_type second__type" id="pdf" style="margin-left: 20%; cursor: pointer">Тип документа 2</div>--}}
{{--        <div class="doc_type threid__type" id="XLS" style="margin-left: 20%; cursor: pointer">Тип документа 3</div>--}}
            <p style="display: none">{{$count++}}</p>
        @endforeach
    </div>
    <div style="display: flex; margin-bottom: 4%">
        <div class="first__type__color"
             style="height:3px;border-width:0;color:gray;background-color:#006BDE;width: 30%;margin-left: 0"></div>
        <div class="second__type__color"
             style="height:3px;border-width:0;color:gray;background-color:#F6F6F6;width: 30%;"></div>
        <div class="threid__type__color"
             style="height:3px;border-width:0;color:gray;background-color:#F6F6F6;width: 30%;"></div>
    </div>
{{--    <form class="catalogControl__searchform" style="margin-left: 5px;width: 40%;">--}}
{{--        <input class="catalogControl__searchInput file_search_input" style="border: 1px solid #E7E9EC; padding: 15px" autocomplete="off"--}}
{{--               type="text" name="file_filter" placeholder="Поиск по товарам" value="">--}}
{{--        <button class="catalogControl__searchBtn file_search_input_btn" type="button">--}}
{{--            <svg>--}}
{{--                <use xlink:href="http://mkrostov.ru/img/sprites/sprite-mono.svg#search"></use>--}}
{{--            </svg>--}}
{{--        </button>--}}
{{--    </form>--}}
    @include('posts.custom._tags')
    <div class="prodCard__docsBody" style="display:flex;flex-wrap: wrap;">

        @foreach($files as $index=>$file)
            @if(substr(strrchr($file->filepath, "."), 1) == 'docx' || substr(strrchr($file->filepath, "."), 1) == 'pdf' || substr(strrchr($file->filepath, "."), 1) == 'XLS')
                <div class="prodCard__docsItemWrp">
                    <div class="prodCard__docsItem">
                        <div class="prodCard__docsSvgBox">
                            <svg>
                                <use
                                    @if(substr(strrchr($file->filepath, "."), 1) == 'docx')
                                        xlink:href="{{ asset('img/sprites/sprite-mono.svg#doc1') }}"></use>
                                @endif
                                @if(substr(strrchr($file->filepath, "."), 1) == 'pdf')
                                    xlink:href="{{ asset('img/sprites/sprite-mono.svg#doc2') }}"></use>
                                @endif
                                @if(substr(strrchr($file->filepath, "."), 1) == 'XLS')
                                    xlink:href="{{ asset('img/sprites/sprite-mono.svg#doc3') }}"></use>
                                @endif
                            </svg>
                        </div>
                        <a class="prodCard__docsName link"
                           href="{{ asset('upload_files/' . $file->filepath) }}">{{ $file->title }}</a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{ $files->links('pagination::bootstrap-4') }}
    @include('layouts.pagination')

</section>
<script>
    console.log(window.innerWidth)
    if (window.innerWidth < 800) {
        $("#buttonDocsBig").hide()
        $("#buttonDocsPhone").show()



    }
</script>
