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
        width: 21cm;
        height: 16.5cm;
        /*background-color: black;*/
    }

    .box {
        display: inline-block;
        width: 6cm;
        height: 1.8cm;
        padding-right: 33px; 
        padding-top: 6px;
    }

    p {
        width: 183.25pt;
        margin-left: 15pt;
        /*color: white;*/
    }
</style>
<body>
    <div class="body">
        <table style="width: 100%">
        </table>
        @for($i = 0; $i < 24; $i++)
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