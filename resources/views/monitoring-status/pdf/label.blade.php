<style>
    * {
        font-size:12px;
        font-family: monospace;
    }

    @page {
        margin: 0mm;
    }

    .body {
        /*width: {{ $width }}pt;
        height: {{ $height }}pt;*/
        /*display: block;*/
        width: 11cm;
        height: 16.5cm;
        /*background-color: black;*/
    }

    .box {
        display: inline-block;
        width: 4cm;
        height: 3cm;
        padding-right: 33px; 
        padding-top: 6px;
        margin: 0 3mm 3mm 0;
    }

    p {
        width: 4cm;
        margin-left: 1.5mm;
        /*color: white;*/
    }
</style>
<body>
    <div class="body">
        @for($i = 0; $i < 10; $i++)
           <div class="box">
                <p>{{ $list['Medrec'] }}<br>
                {{ $list['Firstname'] }} ({{ $list['KdSex'] }})<br>
                {{ date('d/m/Y',strtotime($list['Bod'])) }} {{ $list['UmurThn'] }}thn<br>
                    </p>
           </div>
        @endfor
        <p></p>
        <div style="page-break-after:always;"></div>
   </div>
</body>