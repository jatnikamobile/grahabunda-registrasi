<style type="text/css">
	* {
		font-size: 9pt;
		font-family: Helvetica;
	}
	.header-title {
		padding: 5pt;
	}

	.logo {
		text-align: left;
		display: inline-block;
		vertical-align: top;
		padding: 0 1pt;
		width: 30%;
		height: 70px;
	}
</style>
<div class="header-title">
	<img src="{{ asset('/template/images/thumb/logobpjs.jpg') }}" class="logo">
	<div style="display: inline-block; vertical-align: center; text-align: left; padding-left: 10px; padding-top: 20px;">
		<b>SURAT RUJUKAN</b><br>
		<b>RSUD Raja Ahmad Tabib</b><br>
	</div>
	<div style="float: right; padding-right: 50px; padding-top: 20px;">No. {{ $data->NoRujukan }}<br> Tgl. {{ date('j F Y', strtotime($data->TglRujukan)) }}</div>
</div>
<table style="width: 100%">
	<tr>
		<td style="width: 10%; vertical-align: top;">Kepada Yth</td>
		<td style="width: 1px; vertical-align: top;">:</td>
		<td style="vertical-align: top;">@if($data->TipeRujukan == '0') {{ $data->NmPoli }} <br>@endif {{ $data->NmRujukan }}</td>
		<td><center>== {{ $data->TipeRujukan == '1' ? 'Rujukan Partial' : ($data->TipeRujukan == '0' ? 'Rujukan Penuh' : 'Rujuk Balik') }} ==<br>
			{{ $data->JnsPelayanan == '1' ? 'Rawat Inap': 'Rawat Jalan' }}</center></td>
	</tr>
	<tr>
		
	</tr>
</table>
<p>Mohon Pemeriksaan dan Penanganan Lebih Lanjut:</p>
<table style="width: 100%">
	<tr>
		<td style="width: 20%;">No. Kartu</td>
		<td style="width: 1px;">:</td>
		<td>{{ $data->NoPeserta }}</td>
	</tr>
	<tr>
		<td>Nama Peserta</td>
		<td>:</td>
		<td>{{ $data->Firstname }} ({{ $data->Sex }})</td>
	</tr>
	<tr>
		<td>Tgl Lahir</td>
		<td>:</td>
		<td>{{ $data->Bod }}</td>
	</tr>
	<tr>
		<td>Diagnosa</td>
		<td>:</td>
		<td>{{ $data->Diagnosa }}</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td>{{ $data->Catatan }}</td>
	</tr>
</table>
<p>Demikian atas bantuannya,diucapkan banyak terima kasih.</p>
@if($data->TipeRujukan == '1')
<p>* Rujukan ini Rujukan Parsial, tidak dapat digunakan untuk penerbitan SEP pada FKRTL penerima rujukan.<br>* Tgl.Rencana Berkunjung {{ date('j F Y', strtotime($data->TglRujukan)) }}</p>
@elseif($data->TipeRujukan == '0')
<p>* Rujukan Berlaku Sampai Dengan {{ date('j F Y', strtotime("+90 day". $data->TglRujukan)) }}.<br>* Tgl.Rencana Berkunjung {{ date('j F Y', strtotime($data->TglRujukan)) }}</p>
@else 
<p></p>
@endif
<table style="width: 50%; text-align: center; position: absolute; right: 0;">
	<tbody>
		<tr>
			<td>Mengetahui,</td>
		</tr>
	</tbody>
</table>
<small><?= date("j F Y") ?></small>
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