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
            <h2>Table Data Riwayat Transaksi</h2>
            <ul class="nav navbar-right panel_toolbox">
                <div class="input-group">
                    
                    <!-- <input type="text" class="form-control" placeholder="Ketik untuk mencari...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success"><i class="fa fa-search"></i> </button>
                    </span> -->
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sort-amount-asc"></i> Filter Periode
                    </button>
                    <div class="dropdown-menu periode">
                        <a class="dropdown-item" href="{{ route('historytransactions.index')}}">Semua Transaksi</a>
                        <button class="dropdown-item" onclick="generateDatatables('today')">Hari Ini</button>
                            <button class="dropdown-item" onclick="generateDatatables('yesterday')">Kemarin</button>
                            <a class="dropdown-item" onclick="generateDatatables('seven_days')">7 Hari Terahkir</a>
                            <a class="dropdown-item" onclick="generateDatatables('last30_day')">30 Hari Terahkir</a>
                        <div class="dropdown-divider"></div>
                        <!-- <a class="dropdown-item" href="#">Separa</a> -->
                    </div>
                    
                    <!-- <fieldset> -->
                    <div class="control-group daterange">
                        <div class="controls">
                        <div class="input-prepend input-group">
                            <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="07/08/2021 - 07/12/2021">
                        </div>
                        </div>
                    </div>
                    
                    <!-- </fieldset> -->
                    <a target="_blank" rel="noopener noreferrer" class="btn btn-primary setDataBetween">Sortir</a>
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
                        <th class="column-title">Invoice </th>
                        <th class="column-title">Antrian </th>
                        <th class="column-title">Total </th>
                        <th class="column-title">Pembayaran </th>
                        <th class="column-title">Kembali </th>
                        <th class="column-title">Status </th>
                        <th class="column-title">Tanggal </th>
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
  @include('kasir.historytransactions.modals')
@endsection