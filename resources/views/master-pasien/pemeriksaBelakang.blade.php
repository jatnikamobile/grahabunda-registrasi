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
            <td style="width: 10%; text-align: center; border-right: 1px solid black;"><img src="{{ asset('/template/images/thumb/logo.png') }}" class="logo"></td>
            <td><center>RSUD Raja Ahmad Tabib <br>INSTALASI RAWAT JALAN</center></td>
            <td style="border-left: 1px solid black;"><center><h1>RM 02</h1></center></td>
        </tr>
    </tbody>
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
            <td style="padding-bottom: 850px; border: 1px solid black;"></td>
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