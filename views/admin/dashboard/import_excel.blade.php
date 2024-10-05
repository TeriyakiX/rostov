@extends('admin.layouts.main')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3></h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="ms-3 name">
                                <h5 class="font-bold">Экспорт/Импорт файла excel с каталогом</h5>

                                <br>

                                <a href="{{ route('admin.dashboard.excelDownload') }}" class="text-muted mb-0">
                                    <h6 class="font-bold">
                                        Скачать текущий каталог в excel
                                    </h6>
                                </a>

                                <br>

                                <h6 class="font-bold">
                                    Импортировать новый каталог в формате excel:
                                </h6>
                                <form action="{{ route('admin.dashboard.excelImport') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="file" name="file">
                                    <br><br>
                                    <button class="btn btn-primary">Импортировать</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
