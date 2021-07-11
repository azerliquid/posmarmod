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
                    <p class="lead" id="date">Amount Due 2/22/2014</p>
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

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                <div class=" ">
                    <button class="btn btn-default" onclick="getprint()"><i class="fa fa-print"></i> Print</button>
                    <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
                    <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                </div>
                </div>
            </section>
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


<script>
    $('.setDataBetween').on('click', function() {
        // console.log('APP BTN CHANGE');
        var value = $("input[name=reservation]").val();
        from = value.slice(0,10);
        to = value.slice(13,23);
        // type = [from, to]
        // console.log(type);
        type=`custom?end=${to}&starts=${from}`;
        // console.log(type);
        // console.log('before ' +$('.setTypePrint').data('print'));
        generateDatatables(type);
        $('.setTypePrint').attr('href',`/reporttransaction/create?end=${to}&starts=${from}`);
        // console.log($('.setTypePrint').href());
        // console.log($('.setTypePrint').data('print'));
    });

   

    var myDt=$('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url:"/reporttransaction/",
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('ERROR');
                console.log(xhr.responseText);
                // console.log(thrownError);
            },
        }
        ,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'invoice', name: 'invoice'},
            {data: 'branch_name', name: 'branch_name'},
            {data: 'name', name: 'name'},
            {data: 'queue', name: 'queue', orderable: false, searchable: false},
            {data: 'cashs', name: 'cashs', orderable: false, searchable: false},
            {data: 'pays', name: 'pays', orderable: false, searchable: false},
            {data: 'cash_returns', name: 'cash_returns', orderable: false, searchable: false},
            {data: 'status', name: 'status', searchable: false},
            {data: 'datebaru', name: 'datebaru'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: {
            emptyTable: "Tidak ada data tersedia",
        },
    });

    function generateDatatables(params) {
        // console.log(params);
        // console.log(myDt)
        var urlBaru = "/reporttransaction/"+params
        // console.log(urlBaru);
        myDt.ajax.url(urlBaru).load();   
    }
    
    // modal edit
    function getData(params) {
        var id = params;
        var url = "{{ route('reporttransaction.edit', ":id") }}";
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
                
                setData(result);
            },
            error:function(error){
            console.log(error.responseText);
            }
        });
    };

    function setData(result) {
        $('#invoice b').text("Invoice : "+result[0].invoice);
        $('#kasir').text("Kasir : "+result[0].name);
        $('#cabang').text("Cabang : "+result[0].branch_name);
        var d = new Date(result[0].created_at);
        var date = d.getDate() + " - " + d.getMonth()+ " - " + d.getFullYear();
        $('#tanggal').text("Tanggal : "+ date);
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
        var printContents = document.getElementById("inv_print").innerHTML;
        var originalContents = document.body.innerHTML;
        // document.body.innerHTML = printContents;
        window.print();
        // document.body.innerHTML = originalContents;
    }


    
    
</script>

