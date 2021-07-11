@extends('layouts.app')
@section('content')
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row" style="display: inline-block;" >
    
    </div>
    <!-- /top tiles -->
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
            @if($message = Session::has('message'))
                
            @endif
            <h2>Table Data Products</h2>
            <ul class="nav navbar-right panel_toolbox">
                <div class="input-group">
                    <!-- <input type="text" class="form-control" placeholder="Ketik untuk mencari...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success"><i class="fa fa-search"></i> </button>
                    </span> -->
                    <button id="tambah-modal" type="button" class="btn btn-round btn-info" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus-circle"></i> Tambah Produk</button>
                </div>
            </ul>
            <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action datatable">
                    <thead>
                        <tr class="headings">
                        <th class="column-title">NO </th>
                        <th class="column-title">Kode Produk </th>
                        <th class="column-title">Nama Produk </th>
                        <th class="column-title">Kategori </th>
                        <th class="column-title">Unit </th>
                        <th class="column-title">Harga </th>
                        <th class="column-title no-link last"><span class="nobr">Action</span>
                        </th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div>

@endsection

@section('modals')
  @include('admin.product.modals')
@endsection