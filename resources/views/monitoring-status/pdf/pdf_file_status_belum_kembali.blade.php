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
    LAPORAN FILE BELUM KEMBALI
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
        <tr>
            <td>Poli/SMF</td>
            <td>:</td>
            <td><?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?></td>
        </tr>
    </table>
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
                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                <td>{{ date('H:i:s',strtotime($l->regtime)) }}</td>
                @if($l->tanggalkeluar == '')
                <td></td>
                <td></td>
                @else
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