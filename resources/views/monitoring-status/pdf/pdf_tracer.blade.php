@for($i = 0; $i < $looping; $i++)
<style>
    * {
        font-size:12px;
        font-family: Arial, "Helvetica Neue";
    }

    @page {
        margin: 0mm;
    }

    /* trc-div {
        width: 75 * 2.834645669pt;
        height: 60 * 2.834645669pt;
        padding:10px;
    } */

    .table-list {
        width: 80%;
        border-collapse: collapse;
        margin:auto;
    }

    td {
        border: 1px solid black;
        padding: 10px;
    }
</style>
<div id="trc-div">
    <table class="table-list">
        <tr>
            <td style="width:50%">RSUD Majalaya<br>REGISTRASI PASIEN</td>
            <td style="text-align: right;">{{ $data->NMPoli }}<br>{{ $data->NmDoc }}<br>Tanggal:<br>{{ date('d/m/Y',strtotime($data->Regdate))}} / {{ substr($data->Regtime,11,5) }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">Rekam Medis<br><b style="font-size:24px;">{{ $data->Medrec }}</b></td>
            <td style="text-align: center; border-bottom: 0px;">No Registrasi<br><b>{{ $data->Regno }}</b><br><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($data->Regno,"C128",5,20)}}" height="35" width="100"></td>
        </tr>
        <tr>
            <td style="text-align: center;">Nama & Kategori Pasien<br><b>{{ $data->Firstname }}</b><br>{{ $data->NmKategori }}</td>
            <td style="text-align: center; border-top: 0px;">No Urut<br><b style="font-size:26px;">{{ $data->NomorUrut }}</b></td>
        </tr>
    </table>
</div>
@endfor
<script>
    $(document).ready(function(e) {
        // $("#trc-div").printArea();
        // $("#preview-tracer").printThis();
    });
</script>