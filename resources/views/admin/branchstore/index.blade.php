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
            <h2>Table Data Cabang</h2>
            <ul class="nav navbar-right panel_toolbox">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ketik untuk mencari...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info"><i class="fa fa-search"></i> </button>
                    </span>
                    <button id="tambah-modal" type="button" class="btn btn-round btn-info" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus-circle"></i> Tambah Cabang</button>
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
                        <th class="column-title">Nama Cabang </th>
                        <th class="column-title">No. Telp </th>
                        <th class="column-title">Alamat </th>
                        <th class="column-title">Kasir </th>
                        <th class="column-title">Dapur </th>
                        <th class="column-title">Dapur 2 </th>
                        <th class="column-title no-link last"><span class="nobr">Action</span>
                        </th>
                        </tr>
                    </thead>

                    <tbody>
                    @php $i = 1 @endphp
                    @forelse ($data['branch'] as $d)
                        <td class=" ">{{ $i++ }}</td>
                        <td class=" ">{{ $d['branch_name'] }}</td>
                        <td class=" ">{{ $d['phone'] }} </td>
                        <td class=" ">{{ $d['address'] }} </td>
                        @empty($d->cashier[0])
                                <td style="color:#007bff;">Karyawan Belum Dipilih</td>
                            @else
                                <td data-id="{{ $d->cashier[0]->id_employe }}" class="">{{ $d->cashier[0]->name }} </td>
                        @endempty
                        @empty($d->chef[0])
                                <td style="color:#007bff;">Karyawan Belum Dipilih</td>
                            @else
                                <td data-id="{{ $d->chef[0]->id_employe }}" class=" ">{{ $d->chef[0]->name }} </td>
                        @endempty
                        @empty($d->chef2[0])
                                <td style="color:#007bff;">Karyawan Belum Dipilih</td>
                            @else
                                <td data-id="{{ $d->chef2[0]->id_employe }}" class=" ">{{ $d->chef2[0]->name }} </td>
                        @endempty
                        <td >
                        <a  href="" data-toggle="modal" data-target="#modal-edit" class="editModal last" data-id="{{$d['id_branch']}}">Edit</a>
                        <a  href="" data-toggle="modal" data-target="#modal-hapus" class="hapusModal last" data-id="{{$d['id_branch']}}">Hapus</a>
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
  @include('admin.branchstore.modals')
@endsection