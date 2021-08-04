<script>

    $(function() {
        getData()
    });


    function getData(params) {
        var url = `{{ route('dashboard.create') }}`
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
                url: url,
                type: "GET",
                success: function(result){
                    jQuery('.alert').show();
                    jQuery('.alert').html(result.success);
                    console.log(result);
                    setData(result);
                },
                error:function(error){
                    console.log(error.responseText);
                }
        });
    }

    function setData(params) {
        $('#buyer').text(params.buyer);
        $('#item_sold').text(params.item_sold_daily);
        $('#income').text(kFormatter(params.income));
        $('#outcome').text(kFormatter(params.outcome));
        $('#profit').text(kFormatter(params.profit));

        var most_item = params.favorite
        var total = parseInt(params.item_sold_weekly)
        var markup ='';

        for (let i = 0; i < most_item.length; i++) {
            value = percentage(parseInt(most_item[i].item_sold), total);
            console.log(value);
            
            markup += `<div>
                            <p>${most_item[i].products.code_products + " - " + most_item[i].products.name_products } (${most_item[i].item_sold})</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80" aria-valuenow="79" style="width: ${value}%;"></div>
                                </div>
                            </div>
                        </div>`;
        }

        $('.setMostItem').append(markup);
    }

    function percentage(item, total) {
        return (item/total) * 100;
    }

    function kFormatter(num) {
        return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'K' : Math.sign(num)*Math.abs(num)
    }
</script>