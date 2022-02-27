<style>
    * {
        font-size:12px;
        font-family: Arial, "Helvetica Neue";
    }

    @page {
        margin: 0mm;
    }

    body {
        width: {{ $width }};
        height: {{ $height }};
        line-height: 2;
    }

    .rekammedis {
        font-size: 100px;
    }

    .box {
        position: fixed;
        top: 0.5cm;
        padding-left: 1.5cm;
        padding-bottom: 0.5cm;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
        padding-right: 0.5cm;
        margin-top: 10px;
    }

    .page-break {
        page-break-after: always;
    }
</style>
<body>
   <div class="box">
       <div class="text-center">
            <b style="font-size: 14px;">{{ $list->Medrec }}</b><br>
            <b style="font-size: 16px;">{{ $list->Firstname }}</b><br>
            <b style="font-size: 14px;">{{ date('d-m-Y', strtotime($list->Bod)) }}</b><br>
            <b style="font-size: 14px; margin-top: 10px;">{{ $list->KdSex == 'P' ? 'Perempuan' : 'Laki-laki' }}</b>
       </div>
       <div class="text-right">
           <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($list->Medrec, 'C39')}}" height="25 " width="120">
       </div>
    </div>
</body>