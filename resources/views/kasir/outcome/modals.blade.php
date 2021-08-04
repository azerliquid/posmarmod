<!-- Modal Tambah -->

<div id="modal-tambah" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Form Tambah Pengeluaran</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="tambahForm" action="{{ Route('outcome.store') }}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="item form-group">
        <input type="hidden" name="cashier_name" required="required" class="form-control" value="{{Auth::user()->name}}">
        <input type="hidden" name="id_branch" required="required" class="form-control" value="{{$branch['id_branch']}}">
        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Pengeluaran <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input type="text" required="required" class="form-control" name="name">
          <!-- <small style="color:red;">Nama pengeluaran wajib diisi.</small> -->

        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Harga <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input id="price" type="number" name="price" required="required" class="form-control">
          <!-- <small style="color:red;">Harga wajib diisi.</small> -->

        </div>
      </div>
      <div class="item form-group">
        <label class="col-form-label col-md-3 col-sm-3 label-align" >Jumlah <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input id="qty" type="number" name="qty" required="required" class="form-control">
          <!-- <small style="color:red;">Jumlah wajib diisi.</small> -->

        </div>
      </div>
      <div class="item form-group">
        <label  class="col-form-label col-md-3 col-sm-3 label-align" >Total Pengeluaran <span class="required"> </span>
        </label>
        <div class="col-md-7 col-sm-7 ">
          <input id="outcome" type="number" name="outcome" required="required" class="form-control" value="">
          <!-- <small style="color:red;">Total pengeluaran tidak sama dengan total harga x jumlah.</small> -->

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



<script>
  $('.setDataBetween').on('click', function() {
        console.log('APP BTN CHANGE');
        var value = $("input[name=reservation]").val();
        from = value.slice(0,10);
        to = value.slice(13,23);
        // type = [from, to]
        // console.log(type);
        type=`custom?end=${to}&starts=${from}`;
        console.log(type);
        generateDatatables(type);
    });
    
    var myDt=$('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url:"/outcome/",
            error: function (xhr, ajaxOptions, thrownError) {
                // console.log(xhr.status);
                console.log(xhr.responseText);
                // console.log(thrownError);
            }
        }
        ,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'datebaru', name: 'datebaru' },
            {data: 'prices', name: 'prices', orderable: false, searchable: false},
            {data: 'qty', name: 'qty', orderable: false, searchable: false},
            {data: 'outcomes', name: 'outcomes', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: {
            emptyTable: "Tidak ada data tersedia",
            searchPlaceholder: "Cari Data",
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // pageLength: 5,
        scrollY:"580px",
        scrollCollapse: true,
        info: false,
        select: true,
    });

    function generateDatatables(params) {
        console.log(params);
        console.log(myDt)
        var urlBaru = "/outcome/"+params
        myDt.ajax.url(urlBaru).load();   
    }


    $('#tambah-modal').on('click', function(){
        $('#tambahForm')[0].reset();
    });

    $( "#qty" ).on('input', function() {
        var outcome = parseInt($(this).val()) * parseInt($("#price").val());
        $( "#outcome" ).val(outcome).change();
    });
    

</script>
