@extends('layouts.app')
@section('content')

<div class="right_col" role="main" style="min-height: 1288px;">
    
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Laporan Pendapatan Cabang</h2>
            <ul class="nav navbar-right panel_toolbox">
                <div class="input-group">
                <a target="_blank" rel="noopener noreferrer" class="btn btn-primary setTypePrint" href="{{ route('reportincome.create') }}"><i class="fa fa-print"></i> Print</a>
                    <!-- <input type="text" class="form-control" placeholder="Ketik untuk mencari...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success"><i class="fa fa-search"></i> </button>
                    </span> -->
                        <button type="button" class="btn btn-success dropdown-toggle"  data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-sort-amount-asc"></i> Filter Periode
                        </button>
                        <div class="dropdown-menu periode ">
                            <a class="dropdown-item" href="{{ route('reportincome.index')}}">Semua Transaksi</a>
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
                </div>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">


            <!-- start project list -->
            <table class="table table-striped projects datatable" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 1%">No</th>
                        <th >Cabang</th>
                        <th >Item Terjual</th>
                        <th>Pendapatan Kotor</th>
                        <th>Pengeluaran</th>
                        <th>Pendapatan Bersih</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <!-- end project list -->

            </div>
        </div>
        </div>
    </div>
    </div>
</div>

@endsection


@section('modals')
  @include('admin.income.modals')
@endsection
