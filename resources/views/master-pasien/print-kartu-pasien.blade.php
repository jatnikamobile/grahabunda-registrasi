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
    }

    .rekammedis {
        font-size: 100px;
    }

    .box {
        position: fixed;
        top: 3cm;
        padding-left: 0.5cm;
        padding-bottom: 0.5cm;
    }

    .page-break {
        page-break-after: always;
    }
</style>
<body>
   <div class="box"><b style="font-size: 16px;">{{ $list->Medrec }}</b><br>
        <b>{{ $list->Firstname }}</b><br><b>
        {{ $list->Address }}</b><br><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($list->Medrec, 'C39')}}" height="25 " width="120">
    </div>
</body>