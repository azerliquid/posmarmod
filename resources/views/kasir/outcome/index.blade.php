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
            <h2>Table Data Pengeluaran</h2>
            <ul class="nav navbar-right panel_toolbox">
                <div class="input-group">
                <!-- <a target="_blank" rel="noopener noreferrer" class="btn btn-primary" href="{{ route('reportoutcome.create') }}"><i class="fa fa-print"></i> Print</a> -->

                    <button type="button" class="btn btn-success dropdown-toggle"  data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sort-amount-asc"></i> Filter Periode
                    </button>
                    <div class="dropdown-menu periode ">
                        <a class="dropdown-item" href="{{ route('outcome.index')}}">Semua Transaksi</a>
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
                            <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="07/07/2021 - 07/11/2021">
                        </div>
                        </div>
                    </div>
                    
                    <!-- </fieldset> -->
                    <a target="_blank" rel="noopener noreferrer" class="btn btn-primary setDataBetween">Sortir</a>
                    <button id="tambah-modal" type="button" class="btn btn-round btn-info" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus-circle"></i> Tambah Pengeluaran</button>
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
                        <th class="column-title">Nama </th>
                        <th class="column-title">Tanggal </th>
                        <th class="column-title">Harga </th>
                        <th class="column-title">Qty </th>
                        <th class="column-title">Outcome </th>
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
  @include('kasir.outcome.modals')
@endsection