<!-- Modal Tambah -->

<div id="modal-tambah" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Form Tambah Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="tambahForm" action="{{ Route('employe.store') }}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" required="required" class="form-control" name="name">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align">NIP <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" name="nip" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >No Telp <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="number" name="phone" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Role <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control" name="role">
            <option>Pilih Jabatan</option>
            <option value="kasir">Kasir</option>
            <option value="dapur">Dapur</option>
            <option value="dapur2">Dapur 2</option>
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Email <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="email" name="email" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Password <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="password" name="password" required="required" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>

      </div>
    </div>
  </div>
</div>
<!-- end Modal Tambah -->

<!-- Modal Edit -->

<div id="modal-edit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Form Edit Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="editForm" method="POST" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" required="required" class="form-control" name="name">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align">NIP <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" name="nip" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >No Telp <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" name="phone" required="required" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>

      </div>
    </div>
  </div>
</div>
<!-- end Modal Edit -->

<!-- Modal Hapus -->

<div id="modal-hapus" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel2">Hapus Data Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Apakah anda yakin ingin menghapus data ini ?</h6>
      </div>
      <div class="modal-footer">
      <form id="hapusForm" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </form>
      </div>

    </div>
  </div>
</div>


<script>

      $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url:"{{ route('employe.index') }}",
            error: function (xhr, ajaxOptions, thrownError) {
                // console.log(xhr.status);
                console.log(xhr.responseText);
                // console.log(thrownError);
            },
        }
        ,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'nip', name: 'nip'},
            {data: 'phone', name: 'phone'},
            {data: 'user.name', name: 'user.name'},
            {data: 'role', name: 'role'},
            {data: 'branch', name: 'branch'},
            {data: 'action', name: 'action'},
        ],
        language: {
            emptyTable: "Tidak ada data tersedia",
        },
        
    });
    $('#tambah-modal').on('click', function(){
        $('#tambahForm')[0].reset();
    });

    $('.table tbody').on('click', '.editModal', function(){
        $('#editForm')[0].reset();
        var currow = $(this).closest('tr');
        var col2 = currow.find('td:eq(1)').text();
        var col3 = currow.find('td:eq(2)').text();
        var col4 = currow.find('td:eq(3)').text();
        var col5 = currow.find('td:eq(4)').text();
        var col6 = currow.find('td:eq(5)').text();
        var id = $(this).data('id');
        console.log(col5);
        $('input[name$="name"]').val(col2);
        $('input[name$="nip"]').val(col3);
        $('input[name$="phone"]').val(col4);
        $('textarea[name$="id_branch"]').val(col6);
        $('.role').val(col5).html();
      
        var url = '{{ route("employe.update", ":id") }}';
        url = url.replace(':id', id);
        $('#editForm').attr('action' , url);
        $('#editModal').modal();
    });

    $('.table tbody').on('click', '.hapusModal', function(){
      var id = $(this).data('id');
      var url = '{{ route("employe.destroy", ":id") }}';
      url = url.replace(':id', id);
      $('#hapusForm').attr('action' , url);
      $('#confirmHapusModal').modal("show");
    });
    
</script>
