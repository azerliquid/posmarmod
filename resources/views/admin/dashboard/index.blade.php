@extends('layouts.app')
@section('content')

<div class="right_col" role="main" style="min-height: 1749px;">
<!-- <h1 style="text-align:center;">STATISTIK HARI INI</h1> -->
    <div class="clearfix"></div>
        <!-- top tiles -->
        <div class="row" style="display: inline-block;">
            <div class="tile_count">
                <div class="col-md-2 col-sm-4  tile_stats_count" style="width:700px;">
                    <span class="count_top"><i class="fa fa-user"></i> Total Pembeli</span>
                    <div class="count" id="buyer"></div>
                </div>
                <div class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-clock-o"></i> Item Terjual</span>
                    <div class="count" id="item_sold"></div>
                </div>
                <div class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-clock-o"></i> Penjualan</span>
                    <div class="count blue" id="income"></div>
                </div>
                <div class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Pengeluaran</span>
                    <div class="count red" id="outcome"></div>
                </div>
                <div class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Profit</span>
                    <div class="count green" id="profit"></div>
                </div>
                <!-- <div class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
                    <div class="count">2,315</div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
                    <div class="count">7,325</div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div> -->
            </div>
        </div>
            <!-- /top tiles -->

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                    <h3>Penjualan & Pengeluaran <small>(7 Hari terakhir)</small></h3>
                    </div>
                </div>

                <div class="col-md-9 col-sm-9 ">
                    <div class="x_content">
                        <canvas id="mybarChart"></canvas>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3  bg-white">
                    <div class="x_title">
                    <h2>Item terjual terbanyak</h2>
                    <div class="clearfix"></div>
                    </div>

                    <div class="col-md-12 col-sm-12 setMostItem">
                        
                    </div>

                </div>

                <div class="clearfix"></div>
            </div>
        </div>

        </div>
        <br>
    </div>
</div>
@endsection

@section('modals')
  @include('admin.dashboard.modals')
@endsection