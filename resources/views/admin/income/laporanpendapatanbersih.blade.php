<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<center>
			<h4>Laporan Pendapatan Bersih</h4>
			@if($start != null)
			<p>Periode Tanggal : {{ $start == null ? "Semua" : $start. ' - ' .$end}}</p>
			@else
			<p>Periode Keseluruhan</p>
			@endif
            </center>
		<br/>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Cabang</th>
					<th>Total Item Terjual</th>
					<th>Income</th>
					<th>Outcome</th>
					<th>Profit</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
                @forelse ($data as $d)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                        <a>{{$d->branch_name}}</a>
                        <br>
                        <small>{{$d->address}}</small>
                        </td>
                        <td>
                            {{$d->item_sold == null ? 'Belum ada Transaksi' : $d->item_sold}}
                        </td>
                        <td>
                            {{$d->income == null ? 'Belum ada Pendapatan' : $d->income }}
                        </td>
                        <td>
                            {{$d->outcome == null ? 'Belum ada Pengeluaran' : $d->outcome}}
                        </td>
                        <td>
                            {{$d->income - $d->outcome == null ? 'Belum ada Pendapatan' : $d->income - $d->outcome}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">Tidak ada data</td>
                    </tr>
                    @endforelse
			</tbody>
		</table>

	</div>

    <script>
        window.print();
    </script>

</body>
</html>