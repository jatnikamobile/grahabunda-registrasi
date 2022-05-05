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
    .description-list {
        display: inline-block;
        font-size: 9pt;
        list-style: none;
        padding: 0;
        margin: 0;
        vertical-align: top;
    }
    .description-list li {
        vertical-align: top;
    }

    .description-list li span {
        vertical-align: top;
        display: inline-block;
    }

    .description-list li span:nth-child(1) {
        width: 75pt;
    }

    .description-list li span:nth-child(2) {
        width: 10pt;
        text-align: center;
    }

    .description-list li span:nth-child(3) {
        width: 253pt;
    }

    .description-list-2 li span:nth-child(1) {
        width: 55pt;
    }

    .description-list-2 li span:nth-child(3) {
        width: 150pt;
    }
</style>
<div class="top-header">
    DINAS KESEHATAN<br>
    RSU Graha Bunda
</div>
<div class="title-header">
    LAPORAN FILE STATUS KELUAR
</div>
<div style="display: block;">
    <ul class="description-list">
        <li>
            <span>Periode</span>
            <span>:</span>
            <span><?= $data['set_awal'] ?> s/d <?= $data['set_akhir'] ?></span>
        </li>
        <li>
            <span>Nama Poli</span>
            <span>:</span>
            <span><?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?></span>
        </li>
    </ul>
</div>
<table style="border-collapse:collapse;width:100%;" border="1" id="table-list">
    <thead>
        <tr class="info">
            <th style="width:5%;">No</th>
            <th>No.Reg</th>
            <th>RM</th>
            <th>Nama Pasien</th>
            <th>Tgl Reg</th>
            <th>Jam Reg</th>
            <th>Tgl Klr</th>
            <th>Jam Klr</th>
            <th>Tujuan</th>
            <th>Poli</th>
            <th>Dokter</th>
        </tr>
    </thead>
    <tbody>
        @php
            $n = 0;
        @endphp
        @foreach($list as $key => $l)
            <tr>
                <td>{{ ++$n }}</td>
                <td>{{ $l->regno }}</td>
                <td>{{ $l->medrec }}</td>
                <td>{{ $l->firstname }}</td>
                @if($l->tanggalkeluar == '')
                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                <td>{{ date('H:i:s',strtotime($l->regtime)) }}</td>
                <td></td>
                <td></td>
                @else
                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                <td>{{ date('H:i:s',strtotime($l->regtime)) }}</td>
                <td>{{ date('d/m/Y',strtotime($l->tanggalkeluar)) }}</td>
                <td>{{ date('H:i:s',strtotime($l->jamkeluar)) }}</td>
                @endif
                <td>{{ $l->nmtuju }}</td>
                <td>{{ $l->nmpoli }}</td>
                <td>{{ $l->nmdoc }}</td>
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
    