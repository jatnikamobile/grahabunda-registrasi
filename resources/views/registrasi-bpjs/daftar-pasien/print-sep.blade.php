<style type="text/css">
	* {
		font-size: 9pt;
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
		height: 70px;
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
@for($i = 0; $i < 1; $i++)
<div class="header-title">
	<img src="{{ asset('/template/images/thumb/logobpjs.jpg') }}" class="logo">
	<div style="display: inline-block; vertical-align: top; text-align: center; padding-left: 50px;">
		<b>SURAT ELEGIBILITAS PESERTA</b><br>
		<b>RSUD Raja Ahmad Tabib</b><br>
	</div>
</div>
<table style="width: 100%;">
	<tr><td>
		<table class="description-table" style="width: 100%;">
			<tbody>
				<tr>
					<td style="width: 1.2in;">No. SEP</td>
					<td style="width: 1px;">:</td>
					<td><?= $data['NoSep'] ?></td>
				</tr>
				<tr>
					<td>Tgl. SEP</td>
					<td>:</td>
					<td>{{ date('d/m/Y',strtotime($data['Regdate'])) }}</td>
				</tr>
				<tr>
					<td>No. Kartu</td>
					<td>:</td>
					<td><?= $data['NoPeserta'] ?></td>
				</tr>
				<tr>
					<td>Nama Peserta</td>
					<td>:</td>
					<td><?= $data['Firstname'] ?></td>
				</tr>
				<tr>
					<td>Tgl. Lahir</td>
					<td>:</td>
					<td>{{ date('d/m/Y',strtotime($data['Bod'])) }} Kelamin: <?= $data['Sex'] ?></td>
				</tr>
				<tr>
					<td>No. Telepon</td>
					<td>:</td>
					<td><?= $data['phone'] ?></td>
				</tr>
				<tr>
					<td>Poli Tujuan</td>
					<td>:</td>
					<td><?= $data['NMPoli'] ?></td>
				</tr>
				<tr>
					<td>Faskes Perujuk</td>
					<td>:</td>
					<td><?= $data['NmRujukan'] ?></td>
				</tr>
				<tr>
					<td>Diagnosa Awal</td>
					<td>:</td>
					<td><?= $data['KdIcd'] ?> <?= $data['DIAGNOSA'] ?></td>
				</tr>
			</tbody>
		</table>
	</td><td>
		<table class="description-table" style="width: 100%; top: 0;">
			<tbody>
				<tr>
					<td><?= $data['Prolanis'] ?></td>
				</tr>
				<tr>
					<td style="width: 1.2in;">COB</td>
					<td  style=" width: 1px;">:</td>
					<td><?= $data['kdcob'] == '0' ? 'Tidak': 'Ya' ?></td>
				</tr>
				<tr>
					<td>Jns Rawat</td>
					<td>:</td>
					<td><?= $data['NMTuju'] == 'Rawat Inap' ? 'Rawat Inap': 'Rawat Jalan' ?></td>
				</tr>
				<tr>
					<td>Kls Rawat</td>
					<td>:</td>
					<td><?= $data['NmKelas'] ?></td>
				</tr>
				<tr>
					<td>Penjamin</td>
					<td>:</td>
					<td><?= $data['NMJaminan'] ?></td>
				</tr>
				<tr>
					<td>*No Urut Poli</td>
					<td>:</td>
					<td><?= $data['NomorUrut'] ?></td>
				</tr>
				<tr>
					<td>*No Registrasi / No Rekam Medis</td>
					<td>:</td>
					<td><?= $data['Regno'] ?> / <?= $data['Medrec'] ?></td>
				</tr>
				<tr>
					<td>*Nama Dokter</td>
					<td>:</td>
					<td><?= $data['NmDoc'] ?></td>
				</tr>
				<tr>
					<td>*Admin</td>
					<td>:</td>
					<td><?= $data['ValidUser'] ?></td>
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
			<td></td>
		</tr>
	</tbody>
</table>
<p style="padding-top: 20px;">* Saya Menyetujui BPJS Kesehatan Informasi Medis<br> Pasien jika diperlukan<br>
* SEP bukan sebagai bukti jaminan peserta</p>
<h5>CETAKAN KE : <?= date("jS F Y") ?></h5>
</div>
@endfor
<script>
    // $(document).ready(function(){
    window.print();
    // console.log(window.print());
    // });
    (function() {

        var beforePrint = function() {
            console.log('Functionality to run before printing.');
        };

        var afterPrint = function() {
            console.log('Functionality to run after printing');
            // window.close();
        };

        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;

    }());
</script>