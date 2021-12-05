<style>
    * {
        font-size:12px;
        font-family: monospace;
    }

    @page {
        margin: 0mm;
    }

    .body {
        width: {{ $width }}pt;
    }
</style>
<body>
    <div class="body">
        RSUD Raja Ahmad Tabib
        <div style="padding-top: 10pt; ">
            <center><b>Slip Status Pasien</b></center>
        </div>
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td style="width: 25%;">No. Urut</td>
                <td style="width: 5%;">:</td>
                <td>{{ $list->NomorUrut }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ date('d/m/Y',strtotime($list->Regdate)) }}</td>
            </tr>
            <tr>
                <td>Jam</td>
                <td>:</td>
                <td>{{ substr($list->Regtime,11,5) }}</td>
            </tr>
            <tr>
                <td>No Reg</td>
                <td>:</td>
                <td>{{ $list->Regno }}</td>
            </tr>
            <tr>
                <td>No RM</td>
                <td>:</td>
                <td>{{ $list->Medrec }}</td>
            </tr>
            <tr>
                <td>Nm Pasien</td>
                <td>:</td>
                <td>{{ $list->Firstname }}</td>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td>:</td>
                <td>{{ $list->NMTuju }}</td>
            </tr>
            <tr>
                <td>Poli</td>
                <td>:</td>
                <td>{{ $list->NMPoli }}</td>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <td>{{ $list->NmDoc }}</td>
            </tr>
            <tr>
                <td>Cara Bayar</td>
                <td>:</td>
                <td>{{ $list->NmKategori }}</td>
            </tr>
            <tr>
                <td>Kunjungan</td>
                <td>:</td>
                <td>{{ $list->Kunjungan }}</td>
            </tr>
        </table>
    </div>
    {{ $user }}
</body>