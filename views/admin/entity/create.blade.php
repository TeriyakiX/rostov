@extends('admin.layouts.card-content')

@section('header', 'Добавление записи "' . $config['title'] . '"')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.entity.index', ['entity' => $entity]) }}">{{ $config['title'] }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Добавление записи "{{ $config['title'] }}"</li>
@endsection

@section('page-content')
    <form class="form" method="POST" action="{{ route('admin.entity.store', ['entity' => $entity]) }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        @include('errors._validation')

        <div class="row">
{{--            @dd(\App\Models\Coatings::first()->attributesArray())--}}
            {!! $fieldsHtml !!}
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit"
                                                class="btn btn-primary me-1 mb-1">Добавить</button>
                                        {{--            <button type="reset"--}}
                                        {{--                    class="btn btn-light-secondary me-1 mb-1">Reset</button>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
