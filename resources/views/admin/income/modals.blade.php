<script>
    $('.setDataBetween').on('click', function() {
            console.log('APP BTN CHANGE');
        var value = $("input[name=reservation]").val();
        from = value.slice(0,10);
        to = value.slice(13,23);
        // type = [from, to]
        // console.log(value);
        type=`custom?end=${to}&starts=${from}`;
        console.log(type);
        generateDatatables(type);
        var log = $('.setTypePrint').attr('href',`/reportincome/create?end=${to}&starts=${from}`);
        // console.log(log);
    });

    var myDt=$('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url:"/reportincome/",
            error: function (xhr, ajaxOptions, thrownError) {
                // console.log(xhr.status);
                console.log(xhr.responseText);
                // console.log(thrownError);
            },
        }
        ,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'cabang', name: 'cabang'},
            {data: 'item_sold', name: 'item_sold'},
            {data: 'income', name: 'income'},
            {data: 'outcome', name: 'outcome'},
            {data: 'profit', name: 'profit'},
        ],
        language: {
            emptyTable: "Tidak ada data tersedia",
        },
        
    });

    function generateDatatables(params) {
        var urlBaru = "/reportincome/"+params
        myDt.ajax.url(urlBaru).load();   
             
    }
</script>