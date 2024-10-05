<div class="card-filter">

    <div class="card-filter__wrap">
        <div class="card-filter__title">Категории:</div>
        @if(isset($tags))

        @foreach($tags as $tag)
            <div class="{{ $_SERVER['REQUEST_URI']==='/posts/'. $post->slug.'?tagId='.$tag->id || $_SERVER['REQUEST_URI']==='/posts/'. $post->slug.'?tagId='.$tag->id .'&page='.request()->get('page')
||$_SERVER['REQUEST_URI']==='/documents/'. $post->slug.'?tagId='.$tag->id || $_SERVER['REQUEST_URI']==='/documents/'. $post->slug.'?tagId='.$tag->id .'&page='.request()->get('page')
 ? 'card-filter__holder__active' : 'card-filter__holder' }}">
                <a class="card-filter__item" id="{{$tag->id}}"> <span
                        class="title" >{{$tag->title}}</span> </a>
            </div>
        @endforeach
        @endif
    </div>
</div>

<style>
    .card-filter__holder__active{
        color: white;
        background: #006bde;
        position: relative;
        margin-right: 1%;
        min-width: 4%;
        margin-bottom: 1%;
        text-align: center;
    }
    .card-filter__holder{
        position: relative;
        margin-right: 1%;
        background: #2424240f;
        min-width: 5%;
        cursor: pointer;
        margin-bottom: 1%;
        text-align: center;
    }
    .card-filter__holder:hover{
        background-color: rgba(0, 107, 222, 0.7);
        color: white;
    }
    .card-filter {
        position: relative;
        margin: 0 0 4rem;

        line-height: 1.6rem;
        font-size: 1.3rem;
        color: #6f6f6f;
    }

    .card-filter__wrap {
        display: flex;
        justify-content: flex-start;
        align-content: flex-start;
        align-items: flex-start;
        width: 100%;
        flex-wrap: wrap;
        padding: 1.8rem 0;
    }

    .card-filter__title {
        color: #555555;
        min-width: 10rem;
        padding-right: 1rem;
        font-weight: bold;
        margin: 0.6rem 0;
        font-size: 16px;
    }



    .card-filter__item {
        margin: 0.6rem 0.6rem 0.6rem 0.6rem;
        display: inline-block;
        vertical-align: middle;
        position: relative;
        text-align: center;
    }

</style>
<script>
    $(document).ready(function () {
        $(document).on('click', '.card-filter__item', function () {
            var slug='<?=$post->slug?>';
            var value=$(this).attr("id");
            let params = (new URL(window.location.href)).searchParams;
            let currentId=params.get("tagId");
            console.log(currentId);
            console.log(value);
            let href =  slug;
            if (currentId!==value){
               href =  href+'?'+'tagId='+value;
            }
            document.location.href = href;
        })
    })
</script>
