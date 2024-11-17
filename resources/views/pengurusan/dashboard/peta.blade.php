@extends('layouts.pengurusan.app')

@section('title', 'Peta Aset')

@section('content')
<style>
    a.rm-link {
        color: #e83e8c !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
              <div class="card-body p-0">
                    <iframe src="https://emap.jln.gov.my/arcgis/apps/webappviewer/index.html?id=43427736cb1e43a595e0a53af6ef0663"
            title="Peta" width="100%"style="border:none;height: calc(140vh - 250px);"></iframe>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@endsection
