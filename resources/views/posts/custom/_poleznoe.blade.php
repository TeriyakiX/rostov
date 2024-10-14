
<div class="container__div_one">

    <div class="menuPoleznoe">
        @foreach($usefulChapters as $item)

            <div class="categoryMenu" data-url="{{route('index.posts.show', ['slug' => $item['slug']])}}">
                <a class="categoryMenuLink" href="{{route('index.posts.show', ['slug' => $item['slug']])}}">
                    {{$item['title']}}
                </a>
            </div>
        @endforeach

    </div>

    <div class="poleznoeContent" >

{!! $post->body !!}

    </div>


</div>

<script>
    $(".categoryMenu").click(function () {

        let url = ($(this).data('url'));
        window.location.href = url;
    });
</script>
<style>

h2 {
    font-weight: bold;
}

@media (max-width: 900px) {
    .menuPoleznoe{
        width: 100% !important;
    }
    .poleznoeContent {
        font-size: 14px !important;
        padding: 20px 0 !important;
    }
}
    .menuPoleznoe {
        width: 25%;
        height: auto;
        background: #F6F6F6;
        padding-left: 15px;
        padding-right: 15px;


    }

    .poleznoeContent {
        line-height: 26px;
        font-size: 16px !important;
        padding: 0 20px;
        min-width: 75%;
        display: inline-block;
    }

    .categoryMenu {
        height: 50px;

        padding-top: 15px;
        font-weight: 400;
        font-size: 16px;
        line-height: 150%;
        border-bottom: 1px solid #E2E2E2;
    }

    .categoryMenu:hover:before {
        border: none;
    }

    .categoryMenu:hover {
        background: #006BDE !important;
        margin-right: -15px;
        clip-path: polygon(0 1%, 100% 0%, 90% 100%, 0% 100%);
        color: white;
        border: none;
        cursor: pointer;
    }


    .categoryMenu:last-child {
        border: none;
    }

    .categoryMenuLink {
        padding-left: 20px;

    }


    .container__div_one {
        min-height: 600px;
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        align-items: flex-start;
    }

</style>
