<style type="text/css">
	* {
		font-size: 11pt;
	}
	.header-title {
		padding: 5pt;
		font-family: Helvetica;
	}

	.logo {
		text-align: left;
		display: inline-block;
		vertical-align: top;
		padding: 0 1pt;
		width: 30%;
		height: 30px;
		display:visible;
	}

	.qrcode{
		display: inline-block;
		vertical-align: top;
		width: 100px;
		height: 100px;
	}

	.bold-center {
		font-weight: bold;
		text-align: center;
	}

	.bold-center {
		font-weight: bold;
		text-align: center;
	}

	.description-table td {
		margin: 0;
		padding: 0;
		vertical-align: top;
	}

	.half-split {
		display: inline-block;
		width: 45%;
	}

	.detail-table {
		width: 100%;
		border-collapse: collapse;
	}

	.detail-table th {
		border: 1pt solid black;
		text-align: center;
	}

	.detail-table td {
		border-bottom: 1pt dotted black;
		border-left: 1pt solid black;
		border-right: 1pt solid black;
	}

	.detail-table th,
	.detail-table td {
		padding: 3pt 5pt;
	}

	.signature {
		display: inline-block;
		text-align: center;
		vertical-align: top;
		padding: 0;
		margin: 0;
	}
</style>
<div class="header-title">
	<img src="/template/images/logobpjs1.png" class="logo">
	<div style="display: inline-block; vertical-align: top; text-align: center; padding-left: 50px;">
		<b>SURAT ELEGIBILITAS PESERTA</b><br>
		<b>RSU Graha Bunda</b><br>
	</div>
</div>
<table style="width: 100%;">
	<tr><td>
		<table class="description-table" style="width: 100%;">
			<tbody>
				<tr>
					<td style="width: 1.2in;">No. SEP</td>
					<td>:</td>
					<td style="width: 70%;"><?= $data->nosep ?></td>
				</tr>
				<tr>
					<td>Tgl. SEP</td>
					<td>:</td>
					<td>{{ date('d/m/Y',strtotime($data['regdate'])) }}</td>
				</tr>
				<tr>
					<td>No. Kartu</td>
					<td>:</td>
					<td><?= $data['nopeserta'] ?></td>
				</tr>
				<tr>
					<td>Nama Peserta</td>
					<td>:</td>
					<td><?= $data['firstname'] ?></td>
				</tr>
				<tr>
					<td>Tgl. Lahir</td>
					<td>:</td>
					<td>{{ date('d/m/Y',strtotime($data['bod'])) }} Kelamin: <?= $data['sex'] ?></td>
				</tr>
				<tr>
					<td>No. Telepon</td>
					<td>:</td>
					<td><?= $data['phone'] ?></td>
				</tr>
				<tr>
					<td>Poli Tujuan</td>
					<td>:</td>
					<td><?= $data['nmpoli'] ?></td>
				</tr>
				<tr>
					<td>Faskes Perujuk</td>
					<td>:</td>
					<td><?= $data['nmrujukan'] ?></td>
				</tr>
				<tr>
					<td>Diagnosa Awal</td>
					<td>:</td>
					<td><?= $data['kdicd'] ?> <?= $data['diagnosa'] ?></td>
				</tr>
				<tr>
					<td>Catatan</td>
					<td>:</td>
					<td><?= $data['Catatan'] ?></td>
				</tr>
			</tbody>
		</table>
	</td><td>
		<table class="description-table" style="width: 100%; top: 0;">
			<tbody>
				<tr>
					<td style="width: 1.2in;">Peserta</td>
					<td>:</td>
					<td style="width: 70%;"><?= $data['nmrefpeserta'] ?></td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td style="width: 1.2in;">COB</td>
					<td>:</td>
					<td style="width: 70%;"><?= $data['kdcob'] == '0' ? 'Tidak': 'Ya' ?></td>
				</tr>
				<tr>
					<td>Jns Rawat</td>
					<td>:</td>
					<td>Rawat Inap</td>
				</tr>
				<tr>
					<td>Kls Hak</td>
					<td>:</td>
					<td><?= $hak_kelas ? 'Kelas ' . $hak_kelas : '' ?></td>
				</tr>
				<tr>
					<td>Kls Rawat</td>
					<td>:</td>
					<td>
						@if($data['jtkdkelas'] == '3')
							Kelas 3
						@elseif($data['jtkdkelas'] == '2')
							Kelas 2
						@else 
							Kelas 1
						@endif
					</td>
				</tr>
				<tr>
					<td>Penjamin</td>
					<td>:</td>
					<td><?= $data['nmjaminan'] ?></td>
				</tr>
				<tr>
					<td>*No.Reg/No.RM</td>
					<td>:</td>
					<td><?= $data['regno'] ?> / <?= $data['medrec'] ?></td>
				</tr>
				<tr>
					<td>*Nama Dokter</td>
					<td>:</td>
					<td><?= $data['nmdoc'] ?></td>
				</tr>
				<tr>
					<td>*Admin</td>
					<td>:</td>
					<td><?= $data['validuser'] ?></td>
				</tr>
			</tbody>
		</table>
	</td></tr>
</table>
<table style="width: 50%; text-align: center; position: absolute; right: 0;">
	<tbody>
		<tr>
			<td>Pasien / Keluarga Pasien</td>
			<td>Petugas BPJS Kesehatan</td>
		</tr>
		<tr>
			<td><img src='<?= $qrcode ?>' alt='QR Code' width='100' height='100'></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><?= $data['firstname'] ?></td>
			<td></td>
		</tr>
	</tbody>
</table>
<p style="padding-top: 20px;">* Saya Menyetujui BPJS Kesehatan Informasi Medis<br> Pasien jika diperlukan<br>
* SEP bukan sebagai bukti jaminan peserta</p>
<h5>CETAKAN KE : <?= $data['Nomor'] == '' ? '1' : $data['Nomor']  ?> / <?= $tanggal ?></h5>