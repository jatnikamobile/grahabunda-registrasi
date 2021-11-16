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
    .box {
        border: 1px solid black;
        
        width: 30px;
        padding-right: 10px;
        text-align: center;
    }
    .isian {
        
        padding-left: 10px;
        border: 1px solid black;
    }
    #table-list {
        border-top: 0px solid black;
        border-right: 0px solid black;
        border-left: 0px solid black; 
        border-bottom: 0px solid black;
    }
    td{
        vertical-align: center;
    }
</style>
<div class="top-header">
    DINAS KESEHATAN ANGKATAN UDARA<br>
    RSUD Raja Ahmad Tabib
</div>
<div class="title-header">
    KEYAKINAN DAN NILAI-NILAI
</div>
<table style="width:100%; "id="table-list" cellspacing="10">
    <tbody>
        <tr>
            <td width="5px" style="">1.</td>
            <td style=" width: 35%">Pantang hari Rawat/Pulang</td>
            @if($data->phcek == 1)
                <td class="box">Tidak</td>
                <td class="box"></td>
            @else
                <td class="box"></td>
                <td class="box">Ya</td>
            @endif
            <td class="isian">{{ $data->phnote }}</td>
        </tr>
        <tr>
            <td width="5px" style="">2.</td>
            <td style=" width: 35%">Pantang tindakan</td>
            @if($data->ptcek == 1)
                <td class="box">Tidak</td>
                <td class="box"></td>
            @else
                <td class="box"></td>
                <td class="box">Ya</td>
            @endif
            <td class="isian">{{ $data->ptnote }}</td>
        </tr>
        <tr>
            <td width="5px" style="">3.</td>
            <td style=" width: 35%">Pantang Makan</td>
            @if($data->pmcek == 1)
                <td class="box">Tidak</td>
                <td class="box"></td>
            @else
                <td class="box"></td>
                <td class="box">Ya</td>
            @endif
            <td class="isian">{{ $data->pmnote }}</td>
        </tr>
        <tr>
            <td width="5px" style="">4.</td>
            <td style=" width: 35%">Pantang perawatan oleh lawan jenis</td>
            @if($data->ppcek == 1)
                <td class="box">Tidak</td>
                <td class="box"></td>
            @else
                <td class="box"></td>
                <td class="box">Ya</td>
            @endif
            <td class="isian">{{ $data->ppnote }}</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Lain-lain</td>
            <td colspan="3" class="isian">{{ $data->lain }}</td>
        </tr>
    </tbody>
</table>
<table style="width: 100%; ">
    <tbody>
        <tr>
            <td style=" width: 50%; text-align: center;">Petugas Admision</td>
            <td style=" width: 50%; text-align: center;">Jakarta, {{date('d/m/Y') }} <br>Nama dan tanda tangan keluarga pasien</td>
        </tr>
    </tbody>
</table>
<table style="width: 100%;  padding-top: 50px;">
    <tbody>
        <tr>
            <td style=" width: 50%; text-align: center;">{{ $user }}</td>
            <td style=" width: 50%; text-align: center;">{{ $data->Firstname }}</td>
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
            window.close();
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