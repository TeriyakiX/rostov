@extends('admin.layouts.main')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>@yield('header')</h3>

                    @if (trim($__env->yieldContent('createLink')))
                        @if(strpos(trim($__env->yieldContent('createLink')), 'entity/download_files_type/create') == false && strpos(trim($__env->yieldContent('createLink')), '/entity/download_files/') == false)
                        <a href="@yield('createLink')" class="link-subtitle">Добавить новый +</a>
                        @endif
                    @else
                        <p class="text-subtitle">&nbsp;</a>
                    @endif

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        @yield('page-content')
    </div>
@endsection
