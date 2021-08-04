<!-- Modal Tambah -->

<div id="modal-tambah" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Form Tambah Produk</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="tambahForm" method="POST" data-parsley-validate class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Produk <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahcode">
          <input type="text" required="required" class="form-control" name="code_products">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama Produk <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahname">
          <input type="text" name="name_products" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kategori <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahcategory">
          <select class="form-control" name="id_categorys">
            <option value="">Pilih Kategori</option>
            @php $i = 1 @endphp
            @forelse ($data['category'] as $c)
            <option value="{{$c['id_categorys']}}">{{ $c['categorys']}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Unit <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahunit">
          <select class="form-control" name="id_units">
            <option  value="">Pilih Unit</option>
            @php $i = 1 @endphp
            @forelse ($data['unit'] as $u)
            <option value="{{$u['id_units']}}">{{ $u['units']}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>

        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align">Price <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahprice">
          <input class="date-picker form-control" required="required" type="text" name="price">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btnTambah">Save changes</button>
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
        <h4 class="modal-title" id="myModalLabel">Form Edit Produk</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="editForm" method="POST" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
      <div class="item form-group" >
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Produk <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editcode">
          <input type="text" id="first-name" required="required" class="form-control" name="code_products">
        </div>
      </div>
      <div class="item form-group" >
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama Produk <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editname"> 
          <input type="text" id="last-name" name="name_products" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kategori <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editcategory">
          <select class="form-control category" name="id_categorys">
            <option value="">Pilih Kategori</option>
            @php $i = 1 @endphp
            @forelse ($data['category'] as $c)
            <option value="{{$c['id_categorys']}}">{{ $c['categorys']}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Unit <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 "  id="editunit">
          <select class="form-control units" name="id_units">
            <option value="">Pilih Unit</option>
            @php $i = 1 @endphp
            @forelse ($data['unit'] as $u)
            <option value="{{$u['id_units']}}">{{ $u['units']}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align">Price <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 "  id="editprice">
          <input class="date-picker form-control" required="required" type="number" name="price">
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
        <h4 class="modal-title" id="myModalLabel2">Hapus Data</h4>
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
            url:"{{ route('product.index') }}",
            error: function (xhr, ajaxOptions, thrownError) {
                // console.log(xhr.status);
                console.log(xhr.responseText);
                // console.log(thrownError);
            },
        },
        columns: [
            {data: 'DT_RowIndex',name: 'DT_RowIndex'},
            {data: 'code_products', name: 'code_products'},
            {data: 'name_products', name: 'name_products'},
            {data: 'category', name: 'category'},
            {data: 'unit', name: 'unit'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
     });
    $('#tambah-modal').on('click', function(){
        $('#tambahForm')[0].reset();
    });

    $('.table tbody').on('click', '.editModal', function(){
        $('#editForm')[0].reset();
        var currow = $(this).closest('tr');
        var col2 = currow.find('td:eq(1)').text();
        var col3 = currow.find('td:eq(2)').text();
        var col4 = $(this).data('cat');
        var col5 = $(this).data('unit');
        var col6 = currow.find('td:eq(5)').text().split("Rp. ");
        console.log(currow);
        var id = $(this).data('id');
        $('input[name$="code_products"]').val(col2);
        $('input[name$="name_products"]').val(col3);
        $('.category').val(parseInt(col4)).change();
        $('.units').val(parseInt(col5)).change();
        $('input[name$="price"]').val(parseInt(col6[1]));
      
        var url = '{{ route("product.update", ":id") }}';
        url = url.replace(':id', id);
        $('#editForm').attr('action' , url);
        $('#editModal').modal();
    });
    
    $('.table tbody').on('click', '.hapusModal', function(){
      var id = $(this).data('id');
      var url = '{{ route("product.destroy", ":id") }}';
      url = url.replace(':id', id);
      $('#hapusForm').attr('action' , url);
      $('#confirmHapusModal').modal("show");
    });
    
    $('body').on('click', "#btnTambah", function() {
      event.preventDefault();
      var tambah = $('#tambahForm');
      var formData = tambah.serialize();
      var url = `{{Route("product.store")}}`;
      var jenis = 'tambah';
      console.log(jenis);
      var type = 'POST'
      setValidate(url, type, formData, jenis);
    })

    $('body').on('click', "#btnEdit", function() {
      event.preventDefault();
      var edit = $('#editForm');
      var formData = edit.serialize();
      var url = $('#editForm').attr('action');
      var jenis = 'edit';
      console.log(url);
      var type = 'PUT'
      setValidate(url, type, formData, jenis);
    })

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
                  myDt.ajax.url('/product').load();
              }
        },
      });
    })

    function setValidate(url, type, formData, jenis) {
      $( `#${jenis}code small` ).remove();
      $( `#${jenis}name small` ).remove();
      $( `#${jenis}category small` ).remove();
      $( `#${jenis}unit small` ).remove();
      $( `#${jenis}price small` ).remove();
      $.ajax({
        url: url,
        type: type,
        data:formData,
        success:function (data) {
            console.log(data.errors);
            if(data.errors) {
                    if(data.errors.code_products){
                        $( `#${jenis}code` ).append(`<small style="color:red">${data.errors.code_products[0]}</small>`);
                    }
                    if(data.errors.name_products){
                        $( `#${jenis}name` ).append(`<small style="color:red">${data.errors.name_products[0]}</small>`);
                    }
                    if(data.errors.id_categorys){
                        $( `#${jenis}category` ).append(`<small style="color:red">${data.errors.id_categorys[0]}</small>`);
                    }
                    if(data.errors.id_units){
                        $( `#${jenis}unit` ).append(`<small style="color:red">${data.errors.id_units[0]}</small>`);
                    }
                    if(data.errors.price){
                        $( `#${jenis}price` ).append(`<small style="color:red">${data.errors.price[0]}</small>`);
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
                  myDt.ajax.url('/product').load();
              }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            // console.log(xhr.status);
            console.log(xhr.responseText);
            // console.log(thrownError);
        },
      });
    }
    
    
</script>
