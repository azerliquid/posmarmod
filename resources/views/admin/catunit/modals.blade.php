<!-- Modal Tambah -->

<div id="modal-tambah" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="labelTambah">Form Tambah Kategori</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="tambahForm" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="item form-group">
        <label id="fieldJenisAdd" class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Kategori
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" required="required" class="form-control" name="name">
          <input id="inputJenis" type="hidden" required="required" class="form-control" name="jenis" value="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
      </form>

      </div>
    </div>
  </div>
</div>
<!-- end Modal Tambah -->

<!-- Modal Edit -->

<div id="modal-edit" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="labelEdit"></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="editForm" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
      <div class="item form-group">
        <label id="fieldJenisEdit" class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Kategori
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" required="required" class="form-control" name="name">
          <input id="editJenis" type="hidden" required="required" class="form-control" name="jenis" value="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
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
        <h4 class="modal-title" id="labelHapus"></h4>
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
            
        <input id="hapusJenis" type="hidden" required="required" class="form-control" name="jenis" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </form>
      </div>

    </div>
  </div>
</div>

<script>

// Modal Tambah Data
    $('.btn-add').on('click', function() {
        $('#modal-tambah').modal('show');
        var jenis = $(this).data('jenis');
        $("#labelTambah").text("Tambah Data " + jenis);
        $("#fieldJenisAdd").text("Nama " + jenis);
        $("#inputJenis").val(jenis);
        var url = '{{ route("catunit.store") }}';
        console.log(url);
        $('#tambahForm').attr('action' , url);
    });
    
    // Modal Edit Data
    $('.editModal').on('click', function() {
        $('#modal-edit').modal('show');
        var jenis = $(this).data('jenis');
        $("#labelEdit").text("Edit Data " + jenis);
        $("#fieldJenisEdit").text("Nama " + jenis);
        $("#editJenis").val(jenis);

        var currow = $(this).closest('tr');
        var col2 = currow.find('td:eq(1)').text();
        var id = $(this).data('id');
        $('input[name$="name"]').val(col2);
      
        var url = '{{ route("catunit.update", ":id") }}';
        url = url.replace(':id', id);
        console.log(url);
        $('#editForm').attr('action' , url);
    });
    
    $('.hapusModal').on('click', function(){
      $('#modal-hapus').modal('show');
      var jenis = $(this).data('jenis');
      $("#labelHapus").text("Hapus Data " + jenis);
      $("#hapusJenis").val(jenis);
      var id = $(this).data('id');
      var url = '{{ route("catunit.destroy", ":id") }}';
      url = url.replace(':id', id);
      $('#hapusForm').attr('action' , url);
    });
    
    
</script>