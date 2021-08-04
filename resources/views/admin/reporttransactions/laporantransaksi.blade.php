<!DOCTYPE html>
<html>
<head>
	<title>Laporan Transaksi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<center>
			<h4>Laporan Transaksi</h4>
			<p>Periode : {{ $start == null ? "Semua" :  $start. ' - ' .$end}}</p>
            </center>
		<br/>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>NO </th>
					<th>Invoice </th>
					<th>Cabang </th>
					<th>Kasir </th>
					<th>Antrian </th>
					<th>Total </th>
					<th>Pembayaran </th>
					<th>Kembali </th>
					<th>Tanggal </th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($data as $d)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$d->invoice}}</td>
					<td>{{$d->branch_name}}</td>
					<td>{{$d->name}}</td>
					<td>{{$d->queue}}</td>
					<td>{{$d->cash}}</td>
					<td>{{$d->pay}}</td>
					<td>{{$d->cash_return}}</td>
					<td>{{date('d M Y m:h',strtotime($d->created_at))}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

    <script>
        window.print();
    </script>

</body>
</html>