<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<center>
			<h4>Laporan Pengeluaran</h4>
            </center>
		<br/>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Pengeluaran</th>
					<th>Cabang</th>
					<th>Kasir</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
					<th>Tanggal</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($data as $d)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$d->name}}</td>
					<td>{{$d->branch->branch_name}}</td>
					<td>{{$d->cashier_name}}</td>
					<td>{{$d->price}}</td>
					<td>{{$d->qty}}</td>
					<td>{{$d->outcome}}</td>
					<td>{{date_format($d->created_at, 'd M Y')}}</td>
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