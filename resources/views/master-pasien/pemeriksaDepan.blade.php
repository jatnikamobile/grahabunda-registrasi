<style>
    *{
          font-family: Arial, Helvetica, sans-serif;
          font-size: 12px;
    }

    .logo {
        width: 70px;
        height: 70px;
    }
    .Medrec {
        text-align: right;
        margin-right: 19%;
    }
    .box {
        text-align: center;
        width: 100px;
        border: 1px solid black;
    }
    #table-list {
        margin-top: 10px;
        border: 1px solid black;
    }
    .table-top {
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
        margin-top: 10px;
    }
    th{
        border: 1px solid black;
    }

</style>
<table class="table-top" >
    <tbody>
        <tr>
            <td style="width: 10%; text-align: center; border-right: 1px solid black;"><img src="{{ asset('/template/images/thumb/logo-grahabunda.png') }}" class="logo"></td>
            <td><center>RSUD Raja Ahmad Tabib <br>INSTALASI RAWAT JALAN</center></td>
            <td style="border-left: 1px solid black;"><center><h1>RM 02</h1></center></td>
        </tr>
    </tbody>
</table>
<table style="width:100%; "id="table-list" cellspacing="10">
    <tbody>
        <tr>
            <td style="width: 10%; ">NAMA PASIEN</td>
            <td style=" width: 1%;">:</td>
            <td>{{ $data->Firstname }}</td>
            <td style="text-align: right; right: 0; width: 5%;"><div class="box">{{ $data->Medrec }}</div></td>
        </tr>
        <tr>
            <td>TANGGAL LAHIR</td>
            <td>:</td>
            <td colspan="2">{{ date('d-m-Y',strtotime($data->Bod)) }}/ {{ $data->UmurThn }} THN/ Agama: {{ $data->Agama }}</td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td style="width: 50%;" colspan="2">{{ $data->Address }}</td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td>:</td>
            <td colspan="2">{{ $data->Pendidikan }}</td>
        </tr>
        <tr>
            <td>PEKERJAAN</td>
            <td>:</td>
            <td colspan="2">{{ $data->Pekerjaan }}</td>
        </tr>
        <tr>
            <td>NO TELP/HP</td>
            <td>:</td>
            <td colspan="2">{{ $data->Phone }}</td>
        </tr>
    </tbody>
</table>
<table class="table-top">
    <td style="vertical-align: center;"><center><h1>PEMERIKSAAN PENDERITA</h1></center></td>
</table>
<table class="table-top" >
    <tbody>
        <tr>
            <th><center>Tgl/Poli</center></th>
            <th><center>Riwayat Penyakit dan Pemeriksaan Fisik</center></th>
            <th><center>Diagnosis/Code</center></th>
            <th><center>Tidakan & Terapi</center></th>
            <th><center>Paraf & Nama Dokter</center></th>
        </tr>
        <tr>
            <td style="padding-bottom: 650px; border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
        </tr>
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