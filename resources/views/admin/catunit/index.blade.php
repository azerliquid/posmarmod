@extends('layouts.app')
@section('content')
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row" style="display: inline-block;" >
    
    </div>
    <!-- /top tiles -->

    <!-- Table Category -->
    <div class="col-md-6 col-sm-6  ">
        <div class="x_panel">
            <div class="x_title">
            @if($message = Session::has('message'))
                <div class="alert ui-pnotify-container alert-success ui-pnotify-shadow" role="alert" style="min-height: 16px;">
                    <div class="ui-pnotify-closer" aria-role="button" tabindex="0" title="Close" style="cursor: pointer; visibility: hidden;">
                        <span class="glyphicon glyphicon-remove"></span>
                    </div>
                    <div class="ui-pnotify-sticker" aria-role="button" aria-pressed="true" tabindex="0" title="Unstick" style="cursor: pointer; visibility: hidden;">
                        <span class="glyphicon glyphicon-play" aria-pressed="true"></span>
                    </div>
                    <div class="ui-pnotify-icon">
                        <span class="glyphicon glyphicon-ok-sign"></span>
                    </div>
                    <h4 class="ui-pnotify-title">Berhasil Success</h4>
                    <div class="ui-pnotify-text" aria-role="alert">Sticky success... I'm not even gonna make a joke.</div>
                </div>
            @endif
            <ul class="nav navbar-right panel_toolbox">
            <h4>Table Data Kategori</h4>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ketik untuk mencari...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success"><i class="fa fa-search"></i> </button>
                    </span>
                    <button type="button" class="btn btn-sm btn-round btn-info btn-add" data-toggle="modal" data-jenis="Kategori" ><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
                </div>
            </ul>
            <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="category table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                        <th class="column-title">NO </th>
                        <th class="column-title">Kategori</th>
                        <th class="column-title">Created At </th>
                        <th class="column-title no-link last"><span class="nobr">Action</span>
                        </th>
                        </tr>
                    </thead>

                    <tbody>
                    @php $i = 1 @endphp
                    @forelse ($data['category'] as $c)
                        <td class=" ">{{ $i++ }}</td>
                        <td class=" ">{{ $c['categorys'] }}</td>
                        <td class=" ">{{ $c['created_at'] }}</td>
                        <td >
                        <a  href="" data-toggle="modal" data-target="#modal-edit-cat" class="editModal last" data-id="{{$c['id_categorys']}}" data-jenis="Kategori">Edit</a>
                        <a  href="" data-toggle="modal" data-target="#modal-hapus-cat" class="hapusModal last" data-id="{{$c['id_categorys']}}" data-jenis="Kategori">Hapus</a>
                        </td>
                        </tr>
                    @empty
                        <td colspan="9">Tidak ada data</td>
                    @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 

    <!-- Table Unit -->
    <div class="col-md-6 col-sm-6  ">
        <div class="x_panel">
            <div class="x_title">
            @if($message = Session::has('message'))
                <div class="alert ui-pnotify-container alert-success ui-pnotify-shadow" role="alert" style="min-height: 16px;">
                    <div class="ui-pnotify-closer" aria-role="button" tabindex="0" title="Close" style="cursor: pointer; visibility: hidden;">
                        <span class="glyphicon glyphicon-remove"></span>
                    </div>
                    <div class="ui-pnotify-sticker" aria-role="button" aria-pressed="true" tabindex="0" title="Unstick" style="cursor: pointer; visibility: hidden;">
                        <span class="glyphicon glyphicon-play" aria-pressed="true"></span>
                    </div>
                    <div class="ui-pnotify-icon">
                        <span class="glyphicon glyphicon-ok-sign"></span>
                    </div>
                    <h4 class="ui-pnotify-title">Berhasil Success</h4>
                    <div class="ui-pnotify-text" aria-role="alert">Sticky success... I'm not even gonna make a joke.</div>
                </div>
            @endif
            <ul class="nav navbar-right panel_toolbox">
            <h4>Table Data Unit</h4>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ketik untuk mencari...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success"><i class="fa fa-search"></i> </button>
                    </span>
                    <button type="button" class="btn btn-sm btn-round btn-info btn-add" data-toggle="modal" data-jenis="Unit" data-target="#modal-tambah-unit"><i class="fa fa-plus-circle"></i> Tambah Unit</button>
                </div>
            </ul>
            <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                        <th class="column-title">NO </th>
                        <th class="column-title">Unit</th>
                        <th class="column-title">Created At </th>
                        <th class="column-title no-link last"><span class="nobr">Action</span>
                        </th>
                        </tr>
                    </thead>

                    <tbody>
                    @php $i = 1 @endphp
                    @forelse ($data['unit'] as $u)
                        <td class=" ">{{ $i++ }}</td>
                        <td class=" ">{{ $u['units'] }}</td>
                        <td class=" ">{{ $u['created_at'] }}</td>
                        <td >
                        <a  href="" data-toggle="modal" data-target="#modal-edit" class="editModal last" data-id="{{$u['id_units']}}" data-jenis="Unit">Edit</a>
                        <a  href="" data-toggle="modal" data-target="#modal-hapus" class="hapusModal last" data-id="{{$u['id_units']}}" data-jenis="Unit">Hapus</a>
                        </td>
                        </tr>
                    @empty
                        <td colspan="9">Tidak ada data</td>
                    @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    
     
</div>


@endsection

@section('modals')
  @include('admin.catunit.modals')
@endsection