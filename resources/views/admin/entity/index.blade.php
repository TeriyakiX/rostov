@extends('admin.layouts.card-content')

@section('header', $config['title'])
@section('createLink', route('admin.entity.create', ['entity' => $entity]))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $config['title'] }}</li>

@endsection

@section('page-content')

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">

{{--                            <form action="{{route('admin.entity.index', ['entity' => $entity])}}">--}}
{{--                                <input type="text" name="search" placeholder="Поиск..."--}}
{{--                                       value="{{ request()->get('search') }}"--}}
{{--                                       class="form-control" onchange="$(this).closest('form').submit()">--}}
{{--                            </form>--}}

                            <index-items-component entity="{{ $entity }}"
                                                   url="{{ route('admin.entity.index', ['entity' => $entity, 'search' => request()->get('search')]) }}"></index-items-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
