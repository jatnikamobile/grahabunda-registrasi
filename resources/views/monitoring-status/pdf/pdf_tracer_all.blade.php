@foreach($data as $key => $data)
<style>
    * {
        font-size:12px;
        font-family: Arial, "Helvetica Neue";
    }

    @page {
        margin: 0mm;
    }

    body {
        width: {{ $width }}pt;
        height: {{ $height }}pt;
        padding:5px;
    }

    .table-list {
        width: 95%;
        border-collapse: collapse;
    }

    td {
        border: 1px solid black;
    }
</style>
<body>
    <table class="table-list">
        <tr>
            <td>RSU Graha Bunda<br>REGISTRASI PASIEN</td>
            <td style="text-align: right;">{{ $data->NMPoli }}<br>Tanggal:<br>{{ date('d/m/Y',strtotime($data->Regdate))}} / {{ substr($data->Regtime,11,5) }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">Rekam Medis<br><b>{{ $data->Medrec }}</b></td>
            <td style="text-align: center; border-bottom: 0px;">No Registrasi<br><b>{{ $data->Regno }}</b><br><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($data->Regno, 'C39')}}" height="35" width="100"></td>
        </tr>
        <tr>
            <td style="text-align: center;">Nama & Kategori Pasien<br><b>{{ $data->Firstname }}</b><br>{{ $data->NmKategori }}</td>
            <td style="text-align: center; border-top: 0px;">No Urut<br>{{ $data->NomorUrut }}</td>
        </tr>
    </table>
</body>
@endforeach