<div class="card-filter">

    <div class="card-filter__wrap">
        @if(isset($tags))
        <div class="card-filter__item--wrapper">
            <div class="{{ request()->has('tagId') ? 'card-filter__holder' : 'card-filter__holder__active' }}">
                <a class="card-filter__item" id="all-categories">
                    <span class="title">Все категории</span>
                </a>
            </div>
            @foreach($tags as $tag)
                <div class="{{ $_SERVER['REQUEST_URI']==='/posts/stati'.'?tagId='.$tag->id ||$_SERVER['REQUEST_URI']==='/posts/stati'.'?tagId='.$tag->id.'&page='.request()->get('page')  ? 'card-filter__holder__active' : 'card-filter__holder' }}">
                    <a class="card-filter__item" id="{{$tag->id}}"> <span
                            class="title" >{{$tag->title}}</span> </a>

                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<style>
    .title {
        font-size: 1.4rem;
    }
    .card-filter__item--wrapper {
        display: flex;
        white-space: nowrap;
        position: relative;
        width: 100%;
        margin-left: -8px;
    }
    .card-filter__item--wrapper:before {
        content: '';
        position: absolute;
        z-index: 10;
        width: 18px;
        /*height: -moz-available;*/
        /*height: -webkit-fill-available;*/
        /*height: fill-available;*/
        left: -10px;
        background: #fff;

        height: 100%;
    }

    /*.card-filter__item--wrapper:after {*/
    /*    content: '';*/
    /*    position: absolute;*/
    /*    z-index: 10;*/
    /*    width: 18px;*/
    /*    height: 45px;*/
    /*    right: -5px;*/
    /*    background: #fff;*/
    /*}*/

    .card-filter__holder__active{
        color: white;
        background: #006bde;
        position: relative;
        margin-right: 1%;
        padding: 0 1rem;
        min-width: 5%;
        margin-bottom: 1%;
        text-align: center;
        transform: skew(-20deg);
    }
    .card-filter__holder{
        position: relative;
        margin-right: 1%;
        background: #2424240f;
        min-width: 5%;
        padding: 0 1rem;
        cursor: pointer;
        margin-bottom: 1%;
        text-align: center;
        transform: skew(-20deg);
    }
    .card-filter__holder:last-child {
        padding-right: 1.5rem;
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
        display: inline-block;
        transform: skew(20deg);
        margin: 1.2rem 1rem;
        text-align: center;
        vertical-align: middle;
    }

</style>
<script>
    $(document).ready(function () {
        $(document).on('click', '.card-filter__item', function () {
            var slug='stati';
            var value=$(this).attr("id");

            if (value === 'all-categories') {
                document.location.href = slug;
            } else {
                let params = (new URL(window.location.href)).searchParams;
                let currentId = params.get("tagId");

                let href = slug;
                if (currentId !== value) {
                    href = href + '?' + 'tagId=' + value;
                }
                document.location.href = href;
            }
        });
    });
</script>
