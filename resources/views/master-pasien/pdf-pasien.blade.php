<style>
    *{
          font-family: Arial, Helvetica, sans-serif;
          font-size: 12px;
    }

    .top-header {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        text-align: left;
        width: 220pt;
    }
    .title-header {
        font-size: 14pt;
        font-weight: bold;
        text-align: left;
        margin: 10pt;
    }
    .Medrec {
        text-align: right;
        margin-right: 19%;
    }
    .box {
        position: absolute;
        right: 0;
        text-align: center;
        margin-right: 20%;
        width: 100px;
        border: 1px solid black;
    }
    #table-list {
        border-top: 1px solid black;
        border-right: 1px solid black;
        border-left: 1px solid black; 
        border-bottom: 1px solid black;
        border-collapse: collapse;
    }
    td {
        vertical-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .pull-right {
        width: 100%;
        text-align: right;
    }
</style>
<div class="top-header">
    DINAS KESEHATAN REPUBLIK INDONESIA<br>
    RSUD Raja Ahmad Tabib
</div>
<div class="Medrec">
    NO REKAM MEDIS
    <div class="box">
        <td>{{ $data->Medrec }}</td>
    </div>
</div>
<div class="title-header">
    DATA IDENTITAS PASIEN
</div>
<table style="width:100%; "id="table-list" cellspacing="10">
    <tbody>
        <tr>
            <td style="width: 25%;">NAMA PASIEN</td>
            <td>:</td>
            <td colspan="4">{{ $data->Firstname }} 
                @if($data->UmurThn < 10)
                    , ANAK DARI {{ $data->NamaIbu }}
                    @if($data->GroupUnit == 'DINAS')
                    , {{ $data->NmPangkat }}, {{ $data->NrpNip }}
                    @endif
                @endif</td>
        </tr>
        <tr>
            <td>TEMPAT & TANGGAL LAHIR</td>
            <td>:</td>
            <td>{{ $data->Pod }}, {{ date('d-m-Y',strtotime($data->Bod)) }}</td>
            <td style="text-align: right;">USIA</td>
            <td>:</td>
            <td>{{ $data->UmurThn }} THN</td>
        </tr>
        <tr>
            <td>JENIS KELAMIN</td>
            <td>:</td>
            <td colspan="4">{{ strtoupper($data->Sex) }}</td>
        </tr>
        <tr>
            <td>AGAMA</td>
            <td>:</td>
            <td>{{ $data->Agama }}</td>
            <td style="text-align: right;">KEYAKINAN DAN NILAI-NILAI</td>
            <td>:</td>
            <td>{{ $data->Keyakinan }}</td>
        </tr>
        <tr>
            <td>SUKU</td>
            <td>:</td>
            <td colspan="4">{{ $data->NmSuku }}</td>
        </tr>
        <tr>
            <td>GOLONGAN DARAH</td>
            <td>:</td>
            <td colspan="4">{{ $data->GolDarah }}</td>
        </tr>
        <tr>
            <td>KATEGORI PASIEN</td>
            <td>:</td>
            <td colspan="4">{{ $data->NmKategori }} {{ $data->NmUnit }}</td>
        </tr>
        <tr>
            <td>PEKERJAAN</td>
            <td>:</td>
            <td colspan="4">{{ $data->Pekerjaan }}</td>
        </tr>
        <tr>
            <td>STATUS PERKAWINAN</td>
            <td>:</td>
            <td colspan="4">{{ $data->Perkawinan }}</td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td colspan="4" style="vertical-align: center;">{{ $data->Address }}</td>
        </tr>
        <tr>
            <td>NO TELP/HP</td>
            <td>:</td>
            <td colspan="4">{{ $data->Phone }}</td>
        </tr>
        <tr>
            <td>KELURAHAN</td>
            <td>:</td>
            <td colspan="4">{{ $data->Kelurahan }}, KECAMATAN : {{ $data->Kecamatan }}, KABUPATEN/KOTA : {{ $data->City }}</td>
        </tr>
        <tr>
            <td>PENDIDIKAN TERAKHIR</td>
            <td>:</td>
            <td colspan="4">{{ $data->Pendidikan }}</td>
        </tr>
        <tr>
            <td>PANGGUNG JAWAB</td>
            <td>:</td>
            <td colspan="4">{{ $data->NamaPJ }}</td>
        </tr>
        <tr>
            <td>HUBUNGAN</td>
            <td>:</td>
            <td colspan="4">{{ $data->HubunganPJ }}</td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td colspan="4">{{ $data->AlamatPJ }}</td>
        </tr>
        <tr>
            <td>NO TELP/HP</td>
            <td>:</td>
            <td colspan="4">{{ $data->PhonePJ }}</td>
        </tr>
        <tr>
            <td>TANGGAL PENDAFTARAN</td>
            <td>:</td>
            <td colspan="4">{{ date('d/m/Y',strtotime($data->TglDaftar)) }}</td>
        </tr>
        <tr>
            <td>JAM</td>
            <td>:</td>
            <td colspan="4">{{ date('H:m',strtotime($data->TglDaftar)) }}</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-bottom: 100px;"></td>
        </tr>
    </tbody>
</table>
<div class="pull-right">
    <p>DRM.01</p>
</div>