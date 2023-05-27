<html>

<head>

	<style type="text/css">
		#table_body {
			border-collapse: collapse;
			width: 100%;
		}

		#table_body,
		#table_body th,
		#table_body td {
			border: 1px solid black;
		}

		th,
		td {
			padding: 5px;
			text-align: left;
		}
	</style>
</head>

<body>

	<h1>Laporan</h1>
	<h3>Daftar Sarapan Masuk</h3>
	</h3>
	<h3>Tanggal <?= $date_start . ' '; ?> sampai <?= $date_end . ' '; ?></h3>

	<table id="table_body">
		<thead>
			<th>No</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>No. KTP</th>
			<th>Uraian Aspirasi</th>
			<th>Status</th>
		</thead>
		<tbody>

			<?php
			$no = 1;
			foreach ($sarapan as $lap) : ?>
				<tr>
					<td><?= $no++; ?></td>
					<td><?= $lap->tanggal; ?></td>
					<td><?= $lap->name; ?></td>
					<td><?= $lap->no_ktp; ?></td>
					<td><?= $lap->uraian_sarpan; ?></td>
					<td><?= $lap->status_sarpan; ?></td>
				</tr>

			<?php endforeach; ?>


		</tbody>


	</table>



</body>

</html>