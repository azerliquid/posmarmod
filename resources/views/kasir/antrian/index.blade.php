<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link  href="{{ asset('gentelella-master') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link  href="{{ asset('css') }}/antrian.css" rel="stylesheet">

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-8" >
                <div class="row" >
                    <div class="col-md-12 col1">
                        <div class="row">
                            <div class="col-md-6 col1" id="block2">
                                <span id="date"></span>
                                <h1 id="clock"></h1>
                            
                            </div>
                            <div class="col-md-6 col1" id="block2">
                                <h1>Total Antrian <span id="totalqueue">0</span></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="antrian">ANTRIAN</h1>
                <table class="table table-borderless" border="0">
                    <thead>
                        <tr>
                            <td>Antrian</td>
                            <td>Estimasi Waktu Tunggu</td>
                            <td>Estimasi Waktu Selesai</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <h1 id="antriankosong" style="text-align:center; margin:80px; font-width:bold; font-size:64px"></h1>
            </div>
            <div class="col-4 col2">
                <p>Antrian Saat Ini</p>
                <h1 id="firstqueue">-</h1>
                <p>Estimasi Waktu Tunggu</p>
                <h2 id="firstwaiting">- Menit</h2>
                <p>Estimasi Waktu Selesai</p>
                <h2 id="firstestimate">-</h2>
            </div>
        </div>
    </div>
    
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
        // let data;

        $(function() {
            getData()
        });

        function getData(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                    url: "/queue/getData",
                    type: "POST",
                    success: function(result){
                        jQuery('.alert').show();
                        jQuery('.alert').html(result.success);
                        // console.log(result);
                        setData(result);
                        time();
                    },
                    error:function(error){
                        console.log(error.responseText);
                    }
            });
        }

        // let id_branch;
        let invoice;
        function setData(data) {
            // id_branch = data.id_branch;
            invoice = data.invoice;
            var markup;
            // console.log(data);
            if (data.length == 0) {
                // markup = `<tr> 
                //             <td class=" ">Antrian Tersedia</td>
                //             <td class=" ">Antrian Tersedia</td>
                //             <td class=" ">Antrian Tersedia</td>
                //             <tr>`;
                // $(".table tbody").append(markup);
                
                $("#antriankosong").text("Antrian Tersedia");
                $("#firstqueue").text("-");
                $("#firstwaiting").text("-"+ " Menit");
                $("#firstestimate").text("-");
                $("#totalqueue").text(' '+"0");

            }else{
                $("#antriankosong").text("");
                for (let i = 0; i < invoice.length; i++) {
                    markup = `<tr>
                                <td class=" ">${invoice[i].invoice.queue}</td>
                                <td class=" ">${invoice[i].estimasi} Menit</td>
                                <td class=" ">${invoice[i].waiting}</td>
                                <td class=" ">${invoice[i].invoice.status == 0 ? 'Belum Diproses' : 'Diproses'}</td>
                                <tr>`;
                    var listqueue = $(".table tbody");
                    listqueue.append(markup);
                }
                $("#firstqueue").text(invoice[0].invoice.queue);
                $("#firstwaiting").text(invoice[0].estimasi + " Menit");
                $("#firstestimate").text(invoice[0].waiting);
                $("#totalqueue").text(' '+data.invoice.length);
            }
        }
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('fd04b2a927367843c92f', {
          cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-queue-events'+{{$id_branch}});
        channel.bind('my-queue', function(data) {
          var dataObj = JSON.stringify(data);
          var data = JSON.parse(dataObj);
        //   console.log(data);
          var listqueue = $(".table tbody");
          
            listqueue.html(`
                  <tr>
                      <td colspan="3">Loading....</td>
                  </tr>
            `);
            listqueue.empty();
            getData();            
          
        });


        var channel = pusher.subscribe('my-queue-update'+{{$id_branch}});
        channel.bind('my-queue-update', function(data) {
          var dataObj = JSON.stringify(data);
          var data = JSON.parse(dataObj);
          var listqueue = $(".table tbody");
        //   console.log(listqueue);
          
            listqueue.html(`
                    <tr>
                        <td colspan="3">Loading....</td>
                    </tr>
            `);
            listqueue.empty();
            getData(); 
          
        });

        
        
        function time() {
            var d = new Date();
            var month = new Array();
                month[0] = "January";
                month[1] = "February";
                month[2] = "March";
                month[3] = "April";
                month[4] = "May";
                month[5] = "June";
                month[6] = "July";
                month[7] = "August";
                month[8] = "September";
                month[9] = "October";
                month[10] = "November";
                month[11] = "December";
            var listday = ['Minggu','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var s = d.getSeconds();
            var m = d.getMinutes();
            var h = d.getHours();
            var day = d.getDay();
            var date = listday[d.getDay()] + ", " + d.getDate() + " " + month[d.getMonth()] + " " + d.getFullYear();
            $('#date').text(date);
            var clock = document.getElementById('clock'); 
            clock.textContent  = (("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2) + " WIB");
        }

        setInterval(time, 1000);
</script>
</body>
</html>