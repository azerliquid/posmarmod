@extends('layouts.app')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        


        <div class="page-title">
            <div class="title_left">
            <!-- <h3>Tables <small>Some examples to get you started</small></h3> -->
            </div>

            <!-- <div class="title_right">
            <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
                </div>
            </div> -->
        </div>

        <div class="clearfix"></div>

        <div class="row" style="display: block;">

            <div class="col-md-7 col-sm-7  ">
            
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Produk </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table class="table table-product" id="datatable">
                            <thead>
                            <tr>
                                <th>Kode </th>
                                <th>Produk </th>
                                <th>Kategori </th>
                                <th>Harga </th>
                                <th>Aksi </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Keranjang Produk</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-cart">
                            <thead>
                            <tr>
                                <th>Kode </th>
                                <th>Produk </th>
                                <th>Harga </th>
                                <th>Jumlah </th>
                                <th>Total </th>
                                <th>Aksi </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


            <div class="col-md-5 col-sm-5  ">
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="col-lg-3 col-md-3 col-sm-6  ">
                            <span>Total Pembeli</span>
                            <h3><b>{{ $data['buyer'] }}</b></h3>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6  ">
                            <span>Item Terjual</span>
                            <h3><b>{{ $data['item_sold'] }}</b></h3>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6  ">
                            <span>Penjualan</span>
                            <h3><b>{{ $data['incometotals'] }}</b></h3>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6  ">
                            <span>Pengeluaran</span>
                            <h3><b>{{ $data['outcometotals'] }}</b></h3>
                        </div>
                    </div>
                </div>  
                <div class="x_panel">
                    <div class="x_title" >
                        <h2 >Perhitungan</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-label-left input_mask" action="" method="POST">
                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label class="col-form-label col-md-6 col-sm-6 " style="font-size:14px;">Tanggal </label>
                                <input name="date" type="text" class="form-control no-border" id="date" value="{{date('d M Y')}}" style="border:0;box-shadow:none; background:#fff; font-size:18px; color:#5A738E; font-weight:bold;" readonly>
                            </div>
                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label class="col-form-label col-md-6 col-sm-6 " style="font-size:14px;">Invoice </label>
                                <input name="invoice" type="text" class="form-control no-border" id="invoice" value="{{ $data['invoice'] }}" style="border:0;box-shadow:none; background:#fff; font-size:18px; color:#5A738E; font-weight:bold;" readonly>
                            </div>
                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label class="col-form-label col-md-6 col-sm-6 " style="font-size:14px;">No Antrian </label>
                                <input name="queue" type="text" class="form-control no-border" id="queue" value="{{ $data['queue'] }}" style="border:0;box-shadow:none; background:#fff; font-size:18px; color:#5A738E; font-weight:bold;" readonly>
                            </div>
                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label class="col-form-label col-md-6 col-sm-6 " style="font-size:14px;">Kasir </label>
                                <input class="form-control no-border" id="cashier" value="{{ $data['user']->employe->name }}" style="border:0;box-shadow:none; background:#fff; font-size:18px; color:#5A738E; font-weight:bold;" readonly>
                                <input type="hidden" name="cashier" value="{{ $data['user']->employe->id_user }}">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-8 col-sm-8 offset-md-2" style="text-align:center; font-size:15px;">Total Belanja </label>
                                <div class="col-md-10 col-sm-10 offset-md-1 ">
                                    <input id="setTotal" value="" name="setTotal" type="text" class="form-control" placeholder="Rp. 0" style="text-align:center; border:0;box-shadow:none; background:#fff; font-size:24px; color:#5A738E; font-weight:bold;" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-8 col-sm-8 offset-md-2" style="text-align:center; font-size:15px;">Uang Bayar </label>
                                <div class="col-md-10 col-sm-10 offset-md-1 " id="alertpayment">
                                    <input id="cash" name="cash" type="number" class="form-control" style="border-radius:5px;text-align:center;font-size:24px; color:#5A738E; font-weight:bold;">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-8 col-sm-8 offset-md-2" style="text-align:center; font-size:15px;">Kembalian </label>
                                <div class="col-md-10 col-sm-10 offset-md-1 ">
                                    <input id="return" name="return" type="text" class="form-control" placeholder="Rp. 0" style="text-align:center; border:0;box-shadow:none; background:#fff; font-size:24px; color:#5A738E; font-weight:bold;" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 col-sm-6  offset-md-3 text-center">
                                    <button type="button" class="btn btn-default" style="border: 1px solid #e7e7e7; border-radius:8px;">Cancel</button>
                                    <button type="submit" class="btn btn-success save-data" style="background: #2A3F54; border: 2px solid #e7e7e7; border-radius:8px;">
                                        <span class="spinner-border spinner-border-sm" id="spin" style="display:none" role="status" aria-hidden="true"></span>
                                        <!-- <span class="sr-only">Simpan</span> -->
                                        Simpan
                                    </button>
                                    <!-- <button type="submit" class="btn btn-success save-data" style="background: #2A3F54; border: 2px solid #e7e7e7; border-radius:8px;">
                                        <span class="spinner-border spinner-border-sm" id="spin" style="dislay:none" role="status" aria-hidden="true"></span>
                                        <span class="sr-only">Simpan</span> 
                                        Simpan
                                    </button> -->
                                   
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>
        </div>
        <!-- <div class="myloading" style='position:absolute:display:block:height:1000px;background-color:black;opacity:0.5;z-index:3;'>
            Loading ...
        </div> -->
    </div>
</div>


<!-- /page content -->
@endsection


@section('modals')
  @include('kasir.cashier.modals')
@endsection