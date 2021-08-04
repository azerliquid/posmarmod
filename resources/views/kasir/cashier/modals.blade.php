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
                            <td id="totals">$250.30</td>
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
        <button class="btn btn-default" onclick="getprint()"><i class="fa fa-print"></i> Print</button>
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
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('cashier.index') }}",
        columns: [
            {data: 'code_products', name: 'code_products'},
            {data: 'name_products', name: 'name_products'},
            {data: 'category', name: 'category'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        // pageLength: 5,
        scrollY:"250px",
        // scrollCollapse: true,
        info: false,
        select: true,
     });


    $('.save-data').click(function (event) {
      event.preventDefault();
      $( `#alertpayment small` ).remove();

      let invoice = $("input[name=invoice]").val();
      let queue = Number($("input[name=queue]").val());
      let id_cashier = Number($("input[name=cashier]").val());
      let cash = Number($("input[name=setTotal]").val());
      let pay =  Number($("input[name=cash]").val());
      let cash_return =  Number($("input[name=return]").val());
      var url = '{{ route("cashier.store") }}';

      if (cash >= pay ) {
        return $( `#alertpayment` ).append(`<small style="color:red">Uang bayar lebih kecil dari total</small>`);
      }

      var data = {
        invoice:invoice,
        queue:queue,
        id_cashier:id_cashier,
        cash:cash,
        pay:pay,
        cash_return:cash_return,
      }

      var table = $('.table-cart tbody tr');
      var item = [];
      for (let index = 0; index < table.length; index++) {
        const element = table[index];

        let id = element.id;
        let price = element.children[2].innerText.substring(4);
        let qty = element.children[3].children[0].value;

        item.push({
          id,
          price,
          qty,
        });

      }
      data.item = item;
      // $('#spin').show();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      jQuery.ajax({
        url: url,
        method: 'POST',
        data: {
          data:data,
        },
        success: function(result){
          // console.log(result);
            if(result) {
                $('#modal-tambah').modal('hide');
                Swal.fire({
                  icon: 'success',
                  title: result.success,
                  showConfirmButton: false,
                  timer: 1500
                })
            }
            setInterval(function(){ 
                // window.location.href = "cashier";
              }, 1500);

              setData(result.nota)
              console.log(result.nota);
            

            // console.log(result);
        },
        error:function(error){
          console.log(error.responseText);
        }
      });
    });

    // set return cash
    $( ".atc" ).on(function() {
        var outcome = parseInt($(this).val()) * parseInt($("#price").val());
        $( "#outcome" ).val(outcome).change();
    });


    // Add to cart
    $('.table-product tbody').on('click', '.atc', function(){
        var currow = $(this).closest('tr');
        var col1 = currow.find('td:eq(0)').text();
        var col2 = currow.find('td:eq(1)').text();
        var col3 = currow.find('td:eq(3)').text();
        var id = $(this).data('id');

        var markup = `<tr id="${id}">
                        <td>${col1}</td>
                        <td>${col2}</td>
                        <td>${col3}</td>
                        <td><input type="number" oninput="setqty(this)" data-price="${col3}" data-id="${id}" class="set-qty" value="1" style="width:60px;"></td>
                        <td class="sum-row" id="${"row" + id}">Rp. ${col3.split("Rp. ")[1]}</td>
                        <td>
                        <a data-id="${id}" data-toggle="tooltip" data-placement="right" title="Hapus" style="font-size:11px;" class="delete-row btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>`;
        var tablecart = $(".table-cart tbody");
        tablecart.append(markup);
        $('#add'+id).attr("class", "btn btn-sm btn-warning atc disabled");
    });

    // Delete row from table cart
    $('.table-cart tbody').on('click', '.delete-row', function(){
        var id = $(this).data('id');
        $("#" + id).remove();
        $('#add'+id).attr("class", "btn btn-sm btn-primary atc");
        $('#add'+id).attr("data-toogle", "tooltip");
        $('#add'+id).attr("data-placement", "right");
        $('#add'+id).attr("title", "Tambah");
    });

    // set quantity
    function setqty(e) {
      var price = e.dataset.price.split("Rp. ")[1];
      var sum = price * e.value;
      // console.log(sum);
      $( "#row" + e.dataset.id).text("Rp. " + sum).change();
      setTotal();
    }

    // Set current total
    function setTotal() {
      const tr=$('.sum-row');
      // console.log(tr);
      var total = 0;
      for (let index = 0; index < tr.length; index++) {
        const element = tr[index];
        total+=Number(element.innerText.split("Rp. ")[1]);
        // console.log(element.innerText.split("Rp. ")[1]);
      }
      $('#setTotal').val(total).change();
      
      // console.log("total : " + total);
      return total;
    }

    $('.table-cart').bind('DOMSubtreeModified', function(){
    setTotal();
    });

    $( "#cash" ).on('input', function() {
      var total = Number($('#cash').val()) - Number($('#setTotal').val());
      
        $( "#return" ).val(total).change();
    });
    
    // tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

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
        $('#totals').text(result[0].cash);
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
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.title=invoice;
        window.print();
        window.location.href = 'cashier';
        document.body.innerHTML = originalContents;
    }
</script>
