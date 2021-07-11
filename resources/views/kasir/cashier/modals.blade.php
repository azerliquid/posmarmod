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

      let invoice = $("input[name=invoice]").val();
      let queue = Number($("input[name=queue]").val());
      let id_cashier = Number($("input[name=cashier]").val());
      let cash = Number($("input[name=setTotal]").val());
      let pay =  Number($("input[name=cash]").val());
      let cash_return =  Number($("input[name=return]").val());
      var url = '{{ route("cashier.store") }}';

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
      console.log(data);
      $('#spin').show();
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
            jQuery('.alert').show();
            jQuery('.alert').html(result.success);

            window.location.href = "cashier";
            console.log(result);
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
      console.log(total);
      
        $( "#return" ).val(total).change();
    });
    
    // tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })



</script>
