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
      <form id="tambahForm" method="POST" data-parsley-validate class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahname">
          <input type="text" required="required" class="form-control" name="name" required>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align">NIP <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahnip">
          <input type="number" name="nip" required="required" class="form-control" required>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >No Telp <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 "  id="tambahphone">
          <input type="number" name="phone" required="required" class="form-control" required>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Role <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahrole">
          <select class="form-control" name="role">
            <option value="">Pilih Jabatan</option>
            <option value="kasir">Kasir</option>
            <option value="dapur">Dapur</option>
            <option value="dapur2">Dapur 2</option>
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Email <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahemail">
          <input type="email" name="email" required="required" class="form-control" required>
        </div>
      </div>
      <div class="item form-group" >
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Password <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahpassword">
          <input type="password" name="password" required="required" class="form-control" required>
          <!-- <small style="color:red">Password terdiri kombinasi kapital besar & kecil dan terdapat angka.</small> -->

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btnTambah" type="submit" class="btn btn-primary">Save changes</button>
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
        <div class="col-md-7 col-sm-7 " id="editname">
          <input type="text" required="required" class="form-control" name="name">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align">NIP <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editnip">
          <input type="number" name="nip" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >No Telp <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editphone">
          <input type="text" name="phone" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Role <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editrole">
          <select class="form-control" name="role" id="roleoptionedit">
            <option value="">Pilih Jabatan</option>
            <option value="kasir">Kasir</option>
            <option value="dapur">Dapur</option>
            <option value="dapur2">Dapur 2</option>
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Email <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editemail">
          <input type="email" name="email" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group" id="labelsetpassword">
      <label class="col-form-label col-md-3 col-sm-3 label-align" >
        </label>
        <div class="col-md-7 col-sm-7 ">
          <a  href="javascript:void(0)" onclick="setPassword()">Setting Password Baru</a>
        </div>
      </div>
      <div class="item form-group" id="passwordfield"  style="display: none;">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Password <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editpassword">
          <input type="password" name="password" required="required" class="form-control" required>
          <a href="javascript:void(0)" onclick="cancetSet()" >Batal</a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btnEdit" type="submit" class="btn btn-primary">Save changes</button>
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
        <button id="btnHapus" type="submit" class="btn btn-primary">Save changes</button>
      </form>
      </div>

    </div>
  </div>
</div>


<script>

      var myDt = $('.datatable').DataTable({
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
            {data: 'user.email', name: 'user.email'},
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
        $('#passwordfield').hide();
        $('#labelsetpassword').show();
        var currow = $(this).closest('tr');
        var col2 = currow.find('td:eq(1)').text();
        var col3 = currow.find('td:eq(2)').text();
        var col4 = currow.find('td:eq(3)').text();
        var col5 = currow.find('td:eq(4)').text();
        var col6 = currow.find('td:eq(5)').text();
        var id = $(this).data('id');
        console.log(col6);
        $('input[name$="name"]').val(col2);
        $('input[name$="nip"]').val(col3);
        $('input[name$="phone"]').val(col4);
        $('input[name$="email"]').val(col5);
        $('textarea[name$="id_branch"]').val(col6);
        $("#roleoptionedit option").filter(function() {
          return $(this).text() == col6;
        }).prop('selected', true);
      
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

    $('body').on('click', "#btnHapus", function() {
      event.preventDefault();
      var hapus = $('#hapusForm');
      var formData = hapus.serialize();
      var url = $('#hapusForm').attr('action');
      $.ajax({
        url: url,
        type: 'DELETE',
        data:formData,
        success:function (data) {
              if(data.success) {
                  $(`#modal-hapus`).modal('hide');
                  Swal.fire({
                    icon: 'success',
                    title: data.success,
                    showConfirmButton: false,
                    timer: 1500
                  })
                  myDt.ajax.url('/employe').load();
              }
        },
      });
    })

    $('body').on('click', "#btnTambah", function() {
      event.preventDefault();
      var tambah = $('#tambahForm');
      var formData = tambah.serialize();
      var url = `{{Route("employe.store")}}`;
      var jenis = 'tambah';
      var type = 'POST'
      setValidate(url, type, formData, jenis);      
    })

    $('body').on('click', "#btnEdit", function() {
      event.preventDefault();
      var edit = $('#editForm');
      var formData = edit.serialize();
      var url = $('#editForm').attr('action');
      var jenis = 'edit';
      var type = 'PUT'
      setValidate(url, type, formData, jenis);    
    })

    function setValidate(url, type, formData, jenis) {
      $( `#${jenis}name small` ).remove();
      $( `#${jenis}nip small` ).remove();
      $( `#${jenis}phone small` ).remove();
      $( `#${jenis}email small` ).remove();
      $( `#${jenis}password small` ).remove();
      $( `#${jenis}role small` ).remove();
      $.ajax({
        url: url,
        type: type,
        data:formData,
        success:function (data) {
            console.log(data);
            if(data.errors) {
                    if(data.errors.name){
                        $( `#${jenis}name` ).append(`<small style="color:red">${data.errors.name[0]}</small>`);
                    }
                    if(data.errors.nip){
                        $( `#${jenis}nip` ).append(`<small style="color:red">${data.errors.nip[0]}</small>`);
                    }
                    if(data.errors.phone){
                        $( `#${jenis}phone` ).append(`<small style="color:red">${data.errors.phone[0]}</small>`);
                    }
                    if(data.errors.email){
                        $( `#${jenis}email` ).append(`<small style="color:red">${data.errors.email[0]}</small>`);
                    }
                    if(data.errors.password){
                        $( `#${jenis}password` ).append(`<small style="color:red">${data.errors.password[0]}</small>`);
                    }
                    if(data.errors.role){
                        $( `#${jenis}role` ).append(`<small style="color:red">${data.errors.role[0]}</small>`);
                    }
                    
              }
              if(data.success) {
                  $(`#modal-${jenis}`).modal('hide');
                  Swal.fire({
                    icon: 'success',
                    title: data.success,
                    showConfirmButton: false,
                    timer: 1500
                  })
                  myDt.ajax.url('/employe').load();
              }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            // console.log(xhr.status);
            console.log(xhr.responseText);
            // console.log(thrownError);
        },
      });
    }

    function setPassword() {
      $('#passwordfield').show();
      $('#labelsetpassword').hide();
    }
    function cancetSet() {
      $('#passwordfield').hide();
      $('#labelsetpassword').show();
    }
    
</script>
