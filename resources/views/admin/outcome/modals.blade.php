<script type="text/javascript">
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
            url:"/reportoutcome/",
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
            {data: 'branch_name', name: 'branch_name'},
            {data: 'cashier_name', name: 'cashier_name'},
            {data: 'prices', name: 'prices', orderable: false, searchable: false},
            {data: 'qty', name: 'qty', orderable: false, searchable: false},
            {data: 'outcomes', name: 'outcomes', orderable: false, searchable: false},
            {data: 'datebaru', name: 'datebaru' },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: {
            emptyTable: "Tidak ada data tersedia",
        },
        
    });

    function generateDatatables(params) {
        console.log(params);
        console.log(myDt)
        var urlBaru = "/reportoutcome/"+params
        myDt.ajax.url(urlBaru).load();   
             
    }
  </script>