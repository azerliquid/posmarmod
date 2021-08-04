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
        <link rel="icon" href="{{ asset('gentelella-master') }}/production/images/favicon.ico" type="image/ico" />

        <!-- <title>Gentelella Alela! | </title> -->

        <!-- Bootstrap -->
        <link  href="{{ asset('gentelella-master') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link  href="{{ asset('gentelella-master') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link  href="{{ asset('gentelella-master') }}/build/css/custom.min.css" rel="stylesheet">

        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    </head>
    <body class="nav-md" style="background-color:white;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col col-lg-12">
            <div class="top_nav">
              <div class="nav_menu">
                  <nav class="nav navbar-nav">
                  <ul class=" navbar-right">
                    <li class="nav-item dropdown open" style="padding-left: 15px;">
                      <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{Auth::user()->profile_photo_url}}" alt="">{{ Auth::user()->employe->name }}
                      </a>
                      <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <!-- <a class="dropdown-item"  href="javascript:;"> Profile</a> -->
                      <form method="POST" action="{{ route('logout') }}">
                      @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                                              onclick="event.preventDefault();
                                                    this.closest('form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                      </form>
                      </div>
                    </li>

                    
                  </ul>
                </nav>
              </div>
            </div>
          </div>
          <div class="col col-lg-12 ">
            <!-- <h1>Daftar Pesanan</h1> -->
            <nav aria-label="Page navigation example">
              <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item active"><a class="page-link" href="">Pesanan Tersedia</a></li>
                <!-- <li class="page-item"><a class="page-link" onclick="getData('done')">Pesanan Selesai</a></li> -->
              </ul>
            </nav>
            <h1 id="databaru"></h1>
            <div class="row justify-content-md-center">
              <div class="col col-lg-10">
                <div class="table-responsive">
                    <table class="table jambo_table bulk_action">
                    <thead style="text-align:center;">
                        <tr class="headings">
                        <th class="column-title">Antrian </th>
                        <th class="column-title">Data Pesanan</th>
                        <th class="column-title">Total</th>
                        <th class="column-title no-link last" width="150px"><span class="nobr">Action</span>
                        </th>
                        </tr>
                    </thead>

                    <tbody id="listorder">
                      @php
                        $rowspan=0
                      @endphp
                      @for ($i = 0; $i < count($data); $i++)
                          @for ($j = 0; $j < count($data); $j++)
                            @if($data[$i]->id_invoice == $data[$j]->id_invoice)
                              @php
                                $rowspan=$rowspan+1
                              @endphp
                            @endif
                          @endfor
                          @if($rowspan > 0 && $data[$i]->id_invoice !== ($i > 0 ? $data[$i-1]->id_invoice : "Pembanding"))
                            <tr class="row{{$data[$i]->id_invoice}}">
                                  <td  class="" rowspan="{{ $rowspan }}" style="font-size:28px; font-style:bold; text-align: center;">{{ $data[$i]->id_invoice !== ($i > 0 ? $data[$i-1]->id_invoice : "Pembanding") ? $data[$i]->queue : "" }}</td>
                                  <td class="" rowspan="" style="font-size:16px; ">{{ $data[$i]->name_products }}</td>
                                  <td class="" rowspan="" style="font-size:16px; text-align:center;">{{ $data[$i]->qty }}</td>
                                  <td id="rowaction{{$data[$i]->id_shopping}}" class="" rowspan="">
                                  @if($data[$i]->status == 1)
                                    <a  id="text{{$data[$i]->id_shopping}}" style="font-size:16px;">Sudah dibuat</a>
                                  @else
                                    <a  id="btn{{$data[$i]->id_shopping}}" onclick='start({{$data[$i]->id_shopping}},{{ $data[$i]->id_invoice }},{{ $data[$i]->qty}})' style="color:white; font-size:16px;" class="btn btn-md btn-primary" >Buat</a>
                                  @endif
                                  </td>
                            </tr>
                          @else
                            <tr class="row{{$data[$i]->id_invoice}}">
                                  <td class="" rowspan="" style="font-size:16px; ">{{ $data[$i]->name_products }}</td>
                                  <td class="" rowspan="" style="font-size:16px; text-align:center;">{{ $data[$i]->qty }}</td>
                                  <td id="rowaction{{$data[$i]->id_shopping}}" class="" rowspan="">
                                  @if($data[$i]->status == 1)
                                    <a  id="text{{$data[$i]->id_shopping}}" style="font-size:16px;" >Sudah dibuat</a>
                                  @else
                                    <a  id="btn{{$data[$i]->id_shopping}}" onclick='start({{$data[$i]->id_shopping}},{{ $data[$i]->id_invoice }},{{ $data[$i]->qty}})' style="color:white; font-size:16px;" class="btn btn-md btn-primary" >Buat</a>
                                  @endif
                                  </td>
                            </tr>
                          @endif
                          @php
                            $rowspan=0
                          @endphp
                          
                      @endfor
                    </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

        <!-- jQuery -->
        <script src="{{ asset('gentelella-master') }}/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('gentelella-master') }}/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="{{ asset('gentelella-master') }}/build/js/custom.min.js"></script>

        <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('fd04b2a927367843c92f', {
          cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel'+{{$user->employe->id_branch}});
        channel.bind('my-event', function(data) {
          var dataObj = JSON.stringify(data);
          var data = JSON.parse(dataObj);
          console.log(data);
          var rowspan = data.broadcast_item.length;
          var markup = ``;
          console.log(rowspan);
          for (let i = 0; i < rowspan; i++) {
              markup += `<tr class="row${data.invoice.id_invoice}">
              ${i == 0 && `<td id="rowspan${data.invoice.id_invoice}-${i}" style="font-size:28px; font-style:bold; text-align: center;" rowspan="">${data.invoice.queue}</td>`}
              <td style="font-size:16px;" class="" rowspan="">${data.broadcast_item[i].name_products}</td>
              <td style="font-size:16px; text-align:center;" class="" rowspan="">${data.broadcast_item[i].qty}</td>
              <td id="rowaction${data.broadcast_item[i].id_shopping}" class="" rowspan="">
              <a  id="btn${data.broadcast_item[i].id_shopping}" onclick="start(${data.broadcast_item[i].id_shopping},${data.invoice.id_invoice},${data.broadcast_item[i].qty})" style="color:white; font-size:16px;" class="btn btn-md btn-primary" >Buat</a>
              </td>
              </tr>`;
          }
          $('#listorder').append(markup);
          document.getElementById('rowspan'+data.invoice.id_invoice+'-'+0).setAttribute('rowspan', rowspan);
          console.log(rowspan);
                          
        });
      
      // const d = new Date.now();
      let times = [];

      function start(id, id_invoice, qty) {
        var d = new Date();
        var n = d.getTime();
        console.log('start: '+n);
        if ($('#btn'+id).text() == 'Buat') {
            times.push({
            id:id,
            start:n
            });
            var url = "/listorder/update";
            var data = {id:id, time:null, id_invoice:id_invoice}
            
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            jQuery.ajax({
              url: url,
              method: 'POST',
              data:data,
              success: function(result){
                  jQuery('.alert').show();
                  jQuery('.alert').html(result.success);
                  console.log(result);
                  // window.location.href = "listorder";
              },
              error:function(error){
                  console.log(error.responseText);
              }
            });
            
            $('#btn'+id).text('Selesai');
            $('#btn'+id).css('background-color', 'orange');

        }else{
            var hasil;
            for (let i = 0; i < times.length; i++) {
              if (times[i].id == id) {
                  hasil = (Math.abs(n - times[i].start))/ qty;
              }
            
            }
            console.log(qty);
            console.log(hasil);
            var url = "/listorder/update";
            var data= {id:id,time:hasil, id_invoice:id_invoice};
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            jQuery.ajax({
              url: url,
              method: 'POST',
              data:data,
              success: function(result){
                  jQuery('.alert').show();
                  jQuery('.alert').html(result.success);
                  console.log(result);
                  // window.location.href = "listorder";
                  if (result.length == 0) {
                    $('.row'+id_invoice).remove();
                  }
                  $('#btn'+id).remove();
                  $('#text'+id).css('display', 'block');
                  var status = `<a  id="text${id}" style="font-size:16px;" >Sudah dibuat</a>`;
                  $('#rowaction'+id).append(status);
              },
              error:function(error){
                  console.log(error.responseText);
              }
            });
        }

      
      }
      </script>
          
    </body>
</html> 