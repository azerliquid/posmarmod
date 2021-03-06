<!-- Modal Tambah -->

<div id="modal-tambah" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Form Tambah Cabang</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="tambahForm" method="POST" data-parsley-validate class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Cabang <span class="required">*</span>
        </label> 
        <div class="col-md-7 col-sm-7 " id="tambahname">
          <input type="text" required="required" class="form-control" name="branch_name">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >No Telp <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahphone">
          <input type="number" name="phone" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group" >
        <label class="col-form-label col-md-3 col-sm-3 label-align">Lokasi Cabang <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="tambahaddress">
            <textarea class="form-control" rows="3" placeholder="Masukan Alamat Cabang" name="address"></textarea>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kasir <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control cashier" name="cashier">
            <option value="">Pilih Kasir</option>
            @php $i = 1 @endphp
            @forelse ($data['employe'] as $c)
            <option value="{{$c['id_employe']}}" style="color:{{ $c['branch'] == null ? 'blue' : ''}}">{{ $c['name']. ($c['branch'] == null ? ' (kosong)' : ' ('. $c['branch']->branch_name.')')}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Dapur <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control chef" name="chef">
            <option value="">Pilih Dapur</option>
            @php $i = 1 @endphp
            @forelse ($data['employe'] as $c)
            <option value="{{$c['id_employe']}}" style="color:{{ $c['branch'] == null ? 'blue' : ''}}">{{ $c['name'] }} <strong>{{ ($c['branch'] == null ? ' (kosong)' : ' ('. $c['branch']->branch_name.')')}} </strong></option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Dapur <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control chef" name="chef2">
            <option value="">Pilih Dapur 2</option>
            @php $i = 1 @endphp
            @forelse ($data['employe'] as $c)
            <option value="{{$c['id_employe']}}" style="color:{{ $c['branch'] == null ? 'blue' : ''}}">{{ $c['name']. ($c['branch'] == null ? ' (kosong)' : ' ('. $c['branch']->branch_name.')')}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
          </select>
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
        <h4 class="modal-title" id="myModalLabel">Form Edit Cabang</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="editForm" method="POST" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Cabang <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editname">
          <input type="text" required="required" class="form-control" name="branch_name">
        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >No Telp <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 " id="editphone">
          <input type="text" name="phone" required="required" class="form-control">
        </div>
      </div>
      <div class="item form-group" id="editaddress">
        <label class="col-form-label col-md-3 col-sm-3 label-align">Lokasi Cabang <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
            <textarea class="form-control" rows="3" placeholder="Masukan Alamat Penempatan" name="address"></textarea>
        </div>
      </div>
      <div class="item form-group">
        <input type="hidden" name="id_cashier" value="" >
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kasir <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control cashier" name="cashier" id='cashier'>
            <option value="">Pilih Dapur</option>
                @php $i = 1 @endphp
                @forelse ($data['employe'] as $c)
                <option value="{{$c['id_employe']}}" style="color:{{ $c['branch'] == null ? 'blue' : ''}}">{{ $c['name']. ($c['branch'] == null ? ' (kosong)' : ' ('. $c['branch']->branch_name.')')}}</option>
                @empty
                <td colspan="9">Tidak ada data</td>
                @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
      <input type="hidden" name="id_chef" value="">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Dapur <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control chef" name="chef" id="chef">
            <option value="">Pilih Dapur</option>
              @php $i = 1 @endphp
              @forelse ($data['employe'] as $c)
              <option value="{{$c['id_employe']}}" style="color:{{ $c['branch'] == null ? 'blue' : ''}}">{{ $c['name']. ($c['branch'] == null ? ' (kosong)' : ' ('. $c['branch']->branch_name.')')}}</option>
              @empty
              <td colspan="9">Tidak ada data</td>
              @endforelse
          </select>
        </div>
      </div>
      <div class="item form-group">
      <input type="hidden" name="id_chef2" value="" >

        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Dapur 2 <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <select class="form-control chef2" id="chef2" name="chef2">
            <!-- <option>Pilih Kepala Toko</option> -->
            <option value="">Pilih Dapur 2</option>
            @php $i = 1 @endphp
            @forelse ($data['employe'] as $c)
            <option value="{{$c['id_employe']}}" style="color:{{ $c['branch'] == null ? 'blue' : ''}}">{{ $c['name']. ($c['branch'] == null ? ' (kosong)' : ' ('. $c['branch']->branch_name.')')}}</option>
            @empty
            <td colspan="9">Tidak ada data</td>
            @endforelse
            
          </select>
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
        <h4 class="modal-title" id="myModalLabel2">Hapus Data Cabang</h4>
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

    $('#tambah-modal').on('click', function(){
        $('#tambahForm')[0].reset();
    });
    
    
    $('.table tbody').on('click', '.editModal', function(){
        
        data = {!! json_encode($data['employe'], JSON_HEX_TAG) !!};
        $('#editForm')[0].reset();
        var currow = $(this).closest('tr');
        var col2 = currow.find('td:eq(1)').text();
        var col3 = currow.find('td:eq(2)').text();
        var col4 = currow.find('td:eq(3)').text();
        var col5 = currow.find('td:eq(4)').data('id');
        var col6 = currow.find('td:eq(5)').data('id');
        var col7 = currow.find('td:eq(6)').data('id');
        var id = $(this).data('id');
        console.log('col5   === '+col5);
        $('input[name$="branch_name"]').val(col2);
        $('input[name$="phone"]').val(col3);
        $('input[name$="id_cashier"]').val(col5);
        $('input[name$="id_chef"]').val(col6);
        $('input[name$="id_chef2"]').val(col7);
        $('textarea[name$="address"]').val(col4);
        if (col5) {
          $('.cashier').val(parseInt(col5)).change();
        }
        if (col6) {
          $('.chef').val(parseInt(col6)).change();
        }
        if (col7) {
          $('.chef2').val(parseInt(col7)).change();
        }
      
        var url = '{{ route("branchstore.update", ":id") }}';
        url = url.replace(':id', id);
        $('#editForm').attr('action' , url);
        $('#editModal').modal();
    });

    $('.table tbody').on('click', '.hapusModal', function(){
      var id = $(this).data('id');
      var url = '{{ route("branchstore.destroy", ":id") }}';
      url = url.replace(':id', id);
      $('#hapusForm').attr('action' , url);
      $('#confirmHapusModal').modal("show");
    });

    $('body').on('click', "#btnTambah", function() {
      event.preventDefault();
      var tambah = $('#tambahForm');
      var formData = tambah.serialize();
      var url = `{{Route("branchstore.store")}}`;
      var jenis = 'tambah';
      console.log(jenis);
      var type = 'POST'
      setValidate(url, type, formData, jenis);      
    })

    $('body').on('click', "#btnEdit", function() {
      event.preventDefault();
      var tambah = $('#editForm');
      var formData = tambah.serialize();
      var url = $('#editForm').attr('action');
      var jenis = 'edit';
      var type = 'PUT'
      setValidate(url, type, formData, jenis);      
    })

    function setValidate(url, type, formData, jenis) {
      $( `#${jenis}name small` ).remove();
      $( `#${jenis}phone small` ).remove();
      $( `#${jenis}address small` ).remove();
      $.ajax({
        url: url,
        type: type,
        data:formData,
        success:function (data) {
            console.log(data);
            if(data.errors) {
                    if(data.errors.branch_name){
                        $( `#${jenis}name` ).append(`<small style="color:red">${data.errors.branch_name[0]}</small>`);
                    }
                    if(data.errors.phone){
                        $( `#${jenis}phone` ).append(`<small style="color:red">${data.errors.phone[0]}</small>`);
                    }
                    if(data.errors.address){
                        $( `#${jenis}address` ).append(`<small style="color:red">${data.errors.address[0]}</small>`);
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
                  location.reload();
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
