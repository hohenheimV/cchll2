{{-- @extends('layouts.pengurusan.app')

@section('title', 'Daftar Maklumat Pelan Induk Landskap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                <form action="{{ route('pengurusan.eLIND.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Upload Excel File</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls,.csv">
                        <input type="file" name="file[]" class="form-control" required accept=".xlsx,.xls,.csv" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Import</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
 --}}