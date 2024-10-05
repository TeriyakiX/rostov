<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rostov - Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/summernote/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jquery.dropdown.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.svg') }}" type="image/x-icon">
    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>

<body>
<div id="app">
    @include('admin.layouts._sidebar')
    <div id="main">
        @yield('content')
        @include('admin.layouts._footer')
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin/assets/vendors/apexcharts/apexcharts.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/dashboard.js') }}"></script>

<!-- summernote init -->
<script src="{{ asset('admin/assets/vendors/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script>
    $('#summernote').summernote({
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            },
            onMediaDelete : function(target) {
                // alert(target[0].src)
                deleteFile(target[0].src);
            }
        },
        tabsize: 2,
        height: 300,
    });

    function sendFile(file, editor, welEditable) {
        var lib_url = '{{ route('admin.entity.photoUpload') }}';
        let data = new FormData();
        data.append( "_token", $('meta[name=csrf_token]').attr('content'));
        data.append("file", file);
        $.ajax({
            data: data,
            type: "POST",
            url: lib_url,
            cache: false,
            processData: false,
            contentType: false,
            success: function(url) {
                var image = $('<img>').attr('src', url);
                $('#summernote').summernote("insertNode", image[0]);
            }
        });
    }

    function deleteFile(filename) {
        var lib_url = '{{ route('admin.entity.deleteSummernotePhoto') }}';
        let token = $('meta[name=csrf_token]').attr('content');
        let data = new FormData();
        data.append('filename', filename);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: data,
            type: "POST",
            url: lib_url,
            cache: false,
            processData: false,
            contentType: false,
            success: function(resp) {
                console.log(resp);
            }
        });
    }

    $("#hint").summernote({
        height: 300,
        toolbar: false,
        placeholder: 'type with apple, orange, watermelon and lemon',
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        }
    });
</script>
<!-- /end summernote init -->

<script src="{{ asset('admin/assets/js/main.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.dropdown.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom.js') }}?v=7"></script>
{{--<script src="{{ asset('admin/assets/js/multiselect-dropdown.js') }}" ></script>--}}

</body>

</html>
