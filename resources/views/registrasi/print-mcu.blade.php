<style>
    *{
        font-size:12px;
    }

    .top-header {
        font-family: Helvetica;
        font-weight: bold;
        text-align: left;
        width: 220pt;
    }
    .title-header {
        font-size: 18pt;
        font-weight: bold;
        text-align: center;
        margin: 10pt;
        width: 100%;
        border-bottom: 2px solid black;
    }
</style>
<div class="top-header">
    DINAS KESEHATAN<br>
    RSU Graha Bunda
</div>
<div class="title-header">
    LAPORAN DATA REGISTRASI PASIEN MCU
</div>
<div style="display: block;">
    <table style="width: 100%;">
        <tr>
            <td style="width: 10%;">Periode</td>
            <td>:</td>
            <td><?= $data['set_awal'] ?> s/d <?= $data['set_akhir'] ?></td>
            <td></td>
            <td style=" right: 0; text-align: right;">Tanggal</td>
            <td>:</td>
            <td style=" width: 10%;"><?= date('d-m-Y') ?></td>
        </tr>
    </table>
</div>
<table style="border-collapse:collapse;width:100%;" border="1" id="table-list">
    <thead>
        <tr class="info">
            <th style="width:5%;">No</th>
            <th>Registrasi</th>
            <th>Rekam Medis</th>
            <th>Nama Pasien</th>
            <th>Tgl Reg</th>
            <th>Kunjungan</th>
            <th>Tujuan</th>
            <th>Instansi</th>
            <th>Unit</th>
            <th>Kategori</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
        @php
            $n = 0;
        @endphp
        @foreach($list as $key => $l)
            <tr>
                <td><center>{{ ++$n }}</center></td>
                <td>{{ $l->Regno }}</td>
                <td>{{ $l->Medrec }}</td>
                <td>{{ $l->Firstname }}</td>
                <td>{{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                <td><center>{{ $l->Kunjungan }}</center></td>
                <td>{{ $l->NMTuju }}</td>
                <td>{{ $l->McuInstansi }}</td>
                <td>{{ $l->McuUnit }}</td>
                <td>{{ $l->NmKategori }}</td>
                <td>{{ $l->ValidUser }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
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