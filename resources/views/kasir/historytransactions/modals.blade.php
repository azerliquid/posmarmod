<!-- Modal Edit -->

<div id="modal-detail" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="labelEdit">Data Belanja</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="x_panel" id="inv_print">
            
            <div class="x_content">

            <section class="content invoice">
                <!-- title row -->
                <div class="row">
                <div class="  invoice-header">
                    <h3 id="invoice">
                        <i class="fa  fa-file-text-o">&nbsp;&nbsp;</i><b>Invoice : </b>
                    </h3>
                </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    <address>
                        <h6 id="cabang">Cabang : </h6>
                        <h6 id="kasir">Kasir : </h6>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    <address>
                        <h6 id="tanggal">Tanggal : </h6>
                        <h6 id="antrian">Antrian : </h6>
                    </address>
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                <div class="  table">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>Qty</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="items">
                    </tbody>
                    </table>
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                
                <!-- /.col -->
                <div class="col-md-12">
                    <p class="lead" id="dateinvoice"></p>
                    <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td id="cash">$250.30</td>
                        </tr>
                        <tr>
                            <th>Pembayaran:</th>
                            <td id="pay">$5.80</td>
                        </tr>
                        <tr>
                            <th>Kembali:</th>
                            <td id="cash_return">$265.24</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->

            </section>
            </div>
        </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-invoice="" onclick="getprint()"><i class="fa fa-print"></i> Print</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
      </div>
      </form>

    
      </div>
    </div>
  </div>
</div>
<!-- end Modal Edit -->


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
            url:"/historytransactions/",
            error: function (xhr, ajaxOptions, thrownError) {
                // console.log(xhr.status);
                console.log(xhr.responseText);
                // console.log(thrownError);
            }
        }
        ,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'invoice', name: 'invoice'},
            {data: 'queue', name: 'queue', orderable: false, searchable: false, },
            {data: 'cashs', name: 'cashs', orderable: false, searchable: false},
            {data: 'pays', name: 'pays', orderable: false, searchable: false},
            {data: 'cash_returns', name: 'cash_returns', orderable: false, searchable: false},
            {data: 'status', name: 'status', searchable: false},
            {data: 'datebaru', name: 'datebaru'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: { 
            search: "Cari",
            emptyTable: "Tidak ada data tersedia",
            searchPlaceholder: "Cari Data",
        },
    });

    function generateDatatables(params) {
        console.log(params);
        console.log(myDt)
        var urlBaru = "/historytransactions/"+params
        myDt.ajax.url(urlBaru).load();   
    }
    // Modal Detail Data
    function getData(params) {
        var id = params;
        var url = "{{ route('historytransactions.edit', ":id") }}";
        url = url.replace(':id', id);
        console.log(url);

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        jQuery.ajax({
            url: url,
            method: 'GET',
            data: {
            data:id,
            },
            success: function(result){
                jQuery('.alert').show();
                jQuery('.alert').html(result.success);
                // window.location.href = "historytransactions";
                console.log('berhasil ' + id);
                console.log(result);
                
                setData(result);
            },
            error:function(error){
            console.log(error.responseText);
            }
        });
            
    };

    function setData(result) {
        var month = new Array();
            month[0] = "Januari";
            month[1] = "Februari";
            month[2] = "Maret";
            month[3] = "April";
            month[4] = "Mei";
            month[5] = "Juni";
            month[6] = "Juli";
            month[7] = "Agustus";
            month[8] = "September";
            month[9] = "Oktober";
            month[10] = "November";
            month[11] = "Desember";
        $('#invoice b').text("Invoice : "+result[0].invoice);
        $('#kasir').text("Kasir : "+result[0].name);
        $('#cabang').text("Cabang : "+result[0].branch_name);
        var d = new Date(result[0].created_at);
        var date = d.getDate() + " " + month[d.getMonth()]+ " " + d.getFullYear();
        $('#tanggal').text("Tanggal : "+ date);
        $('#dateinvoice').text("Tanggal : "+ date);
        $('#cabang').text("Cabang : "+result[0].branch_name);
        $('#antrian').text("Antrian : "+result[0].queue);
        $('#cash').text(result[0].cash);
        $('#pay').text(result[0].pay);
        $('#cash_return').text(result[0].cash_return);

        var markupitem = "";
        var totals = 0;
        for (let index = 0; index < result.length; index++) {
            markupitem+=`<tr>
            <td>${result[index].qty}</td>
            <td>${result[index].name_products}</td>
            <td>${result[index].price}</td>
            <td>${result[index].totals}</td>
            </tr>`
        }

        $("#items").html(markupitem)

        $('#modal-detail').modal('show');
    }

    // print invoice
    function getprint() {
        var invoice = $('#invoice b').text().replace("Invoice : ", "");
        
        var printContents = document.getElementById("inv_print").innerHTML;
        // console.log(printContents);
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.title=invoice;
        window.print();
        window.location.href = '/historytransactions';
        document.body.innerHTML = originalContents;
        // console.log(document.body.innerHTML);
        // $('#modal-detail').modal('hide');
        // console.log('oke');
    }

    function setSelesai(id) {
        var url = "/historytransactions/update";
        var data= {id:id};
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: url,
            method: 'PUT',
            data:data,
            success: function(result){
                jQuery('.alert').show();
                jQuery('.alert').html(result.success);
                console.log(result);
                if (result == 'success') {
                    $('#btn'+id).remove();
                }
                window.location.href = "historytransactions";
            },
            error:function(error){
                console.log(error.responseText);
            }
        });
    }

    
    
</script>

