<head>
    <style type="text/css" >
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        .bordered-table {
            border-collapse: collapse;
        }

        .bordered-table th {
            border: solid 1px black;
            padding: 3px 5px;
            text-align: center;
        }

        .bordered-table td {
            border: solid 1px black;
            padding: 3px 5px;
        }

        .title-table {
            width: 100%; font-weight: bold;
            margin-bottom: 10px;
        }
        .page_break { 
            page-break-before: always; 
        }
    </style>
</head>
<body>

    <div style = "width: 33%; text-align: center; border-bottom: 1px solid black; margin-bottom: 0px "> 
        <span>RUMAH SAKIT ANGKATAN UDARA </span><br> 
        <span>dr. ESNAWAN ANTARIKSA  </span> 
    </div>
    <div style = "width: 100%; text-align: center;  margin-bottom: 20px; margin-top: 0px "> 
        <span><h2 style="font-size: 20px">RINGKASAN PASIEN MASUK & KELUAR</h2></span>
    </div>
    {{-- {{dd($pasien)}} --}}
    <table style="border-collapse: collapse; width: 100%; margin-top: 0px; margin-bottom: 10px; ">
        <tr>
            <td style="width: 70%; ">
                
            </td>
            <td style="width: 120px; ">
                <span style="padding-left:0px">KATEGORI PASIEN</span>
                <br><br>
                <span style="padding-left:0px">NO REKAM MEDIC</span>
            </td>
            <td style="padding-left: 1px; width: 1px">:<br><br>:</td>
            <td style="padding-right: 0px;">{{@$pasien->NmKategori}}<br><br>{{@$pasien->Medrec}}</td>
        </tr>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:20%; border-left: 0; border-right: 0"><span style="padding-top: 0px;">NAMA KELUARGA</span><br><br></td>
                <td style="vertical-align: top; text-align: center; width:10%; border-left: 0; border-right: 0"><span style="padding-top: 0px">(Nn, Ny <br> Bin, bt)</span><br><br></td>
                <td style="vertical-align: top; text-align: center;width:25%; border-left: 0"><span>NAMA PASIEN</span><br><br>{{@$pasien->Firstname}}</td>
                <td style="vertical-align: top; text-align: center;width:15%"><span>RUANG</span><br><br>{{@$pasien->NmBangsal}}</td>
                <td style="vertical-align: top; text-align: center;width:10%"><span>KELAS</span><br><br>{{@$pasien->NMKelas}}</td>
                <td style="vertical-align: top; text-align: center;width:30%; border-right: 0"><span>dr. KEPALA UNIT</span><br><br></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:60%; border-left: 0; border-top: 0"><span style="padding-top: 0px;">ALAMAT / TELEPON</span><br><br>{{@$pasien->Address}} / {{@$pasien->Phone}}</td>
                <td style="text-align: center;width:20%; border-top: 0"><span style="padding-top: 0px;">TEMPAT, T LAHIR</span><br><br>{{@$pasien->Pod}}<br>{{date('d-m-Y',strtotime(@$pasien->Bod))}}</td>
                <td style="vertical-align: top; text-align: center;width:30%; border-top: 0; border-right: 0"><span>PENANGGUNG JAWAB</span><br><br>{{@$pasien->NamaPJ}}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:12%; border-left: 0; border-top: 0"><span style="padding-top: 0px">UMUR</span><br><br>{{@$pasien->UmurThn}}</td>
                <td style="vertical-align: top; text-align: center;width:10%; border-top: 0"><span style="padding-top: 0px">PERKAWINAN</span><br><br>{{@$pasien->Perkawinan}}</td>
                <td style="vertical-align: top; text-align: center;width:10%; border-top: 0"><span style="padding-top: 0px">L/P</span><br><br>{{@$pasien->Sex}}</td>
                <td style="vertical-align: top; text-align: center;width:10%; border-top: 0"><span>AGAMA</span><br><br>{{@$pasien->Agama}}</td>
                <td style="vertical-align: top; text-align: center;width:10%; border-top: 0"><span style="padding-top: 0px">KEYAKINAN</span><br><br>{{@$pasien->Keyakinan}}</td>
                <td style="vertical-align: top; text-align: center;width:10%; border-top: 0"><span>PENDIDIKAN</span><br><br>{{@$pasien->Pendidikan}}</td>
                <td style="vertical-align: top; text-align: center;width:10%; border-top: 0;"><span>PEKERJAAN</span><br><br>{{@$pasien->Pekerjaan}}</td>
                <td style="vertical-align: top; text-align: center;width:20%; border-top: 0; border-right: 0"><span>WARGA NEGARA</span><br><br>{{@$pasien->WargaNegara}}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:23.9%; border-left: 0; border-top: 0"><span style="padding-top: 0px;">NAMA IBU</span><br><br>{{@$pasien->NamaIbu}}</td>
                <td style="vertical-align: top; text-align: left;width:20%; border-top: 0"><span style="padding-top: 0px;">NAMA AYAH</span><br><br>{{@$pasien->NamaAyah}}</td>
                <td style="vertical-align: top; text-align: left;width:22%; border-top: 0"><span style="padding-top: 0px;">PEKERJAAN</span><br><br></td>
                <td style="vertical-align: top; text-align: left;width:30%; border-top: 0; border-right: 0"><span>ALAMAT</span><br><br></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:32.5%; border-left: 0; border-top: 0"><span style="padding-top: 0px;">NAMA YANG DAPAT DIHUBUNGI</span><br><br>{{@$pasien->NamaPJ}}</td>
                <td style="vertical-align: top; text-align: left;width:10%; border-top: 0"><span style="padding-top: 0px;">HUBUNGAN</span><br><br>{{@$pasien->HubunganPJ}}</td>
                <td style="vertical-align: top; text-align: left;width:22%; border-top: 0"><span style="padding-top: 0px;">PEKERJAAN</span><br><br>{{@$pasien->PekerjaanPJ}}</td>
                <td style="vertical-align: top; text-align: left;width:30%; border-top: 0; border-right: 0"><span>ALAMAT</span><br><br>{{@$pasien->AlamatPJ}}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 35px">
                <td style="vertical-align: center; text-align: left;width:25.3%; border-left: 0; border-top: 0"><span style="padding-top: 0px;">DIKIRIM OLEH</span>&nbsp;&nbsp;</td>
                <td style="vertical-align: center; text-align: left;width:30%; border-top: 0; border-right: 0"><span>ALAMAT</span>&nbsp;&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="">
                <td style="vertical-align: top; text-align: left;width:12%; border-left: 0; border-top: 0" rowspan="2"><span style="padding-top: 0px;">TANGGAL MASUK</span><br><br>{{date('d/m/Y',strtotime(@$pasien->Regdate))}}</td>
                <td style="vertical-align: top; text-align: left;width:10%; border-top: 0" rowspan="2"><span style="padding-top: 0px;">JAM</span><br><br>{{ substr(@$pasien->Regtime,11,5) }}</td>
                <td style="vertical-align: bottom; text-align: center;width:10%; border-top: 0" colspan="2"><span style="padding-top: 0px;">TGL KELUAR</span></td>
                <td style="vertical-align: top; text-align: left; width:15%; border-top: 0; border-right: 0" rowspan="2"><span>JAM</span>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td style="vertical-align: center; text-align: left;width:20%; border-top: 0; border-right: 0"><span style="padding-top: 0px;">PINDAH KE</span></td>
                <td style="vertical-align: center; text-align: left;width:20%; border-top: 0; border-left: 0"><span>TTD PERAWAT</span>&nbsp;&nbsp;</td>
            </tr>
        </tbody>
    </table>
    {{-- {{dd($pasien)}} --}}
    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:40%; border-left: 0; border-right: 0; border-top: 0"><span style="padding-top: 0px;">DIAGNOSA SEMENTARA (WAKTU MASUK)<br><br>GEJALA GELAJA UTAMA PASIEN</span></td>
                <td style="vertical-align: top; text-align: left;width:40.5%; border-top: 0; border-left: 0"><span style="padding-top: 0px;"></span>{{substr(@$pasien->DIAGNOSA,4)}}<br><br></td>
                <td style="vertical-align: top; text-align: left; width:30%; border-top: 0; border-right: 0"><span>KODE PENYAKIT</span><br><br>{{@$pasien->kdicd}}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:40%; border-left: 0; border-right: 0; border-top: 0"><span style="padding-top: 0px;">DIAGNOSA AKHIR (WAKTU DIPULANGKAN)</span></td>
                <td style="vertical-align: top; text-align: left;width:40.5%; border-top: 0; border-left: 0"><span style="padding-top: 0px;"></span></td>
                <td style="vertical-align: top; text-align: left; width:30%; border-top: 0; border-right: 0"><span>KODE PENYAKIT</span><br><br></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 150px">
                <td style="vertical-align: top; text-align: left;width:40%; border-left: 0; border-right: 0; border-top: 0"><span style="padding-top: 0px;"></span></td>
                <td style="vertical-align: top; text-align: left;width:40.5%; border-top: 0; border-left: 0"><span style="padding-top: 0px;"></span></td>
                <td style="vertical-align: top; text-align: left; width:30%; border-top: 0; border-right: 0"><span></span><br><br></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 30px">
                <td style="vertical-align: center; text-align: left;width:40%; border-left: 0; border-right: 0; border-top: 0"><span style="padding-top: 0px;">DIANJURKAN ISTIRAHAT SETELAH KELUAR</span></td>
                <td style="vertical-align: center; text-align: left;width:40.5%; border-top: 0; border-left: 0"><span style="padding-top: 0px;"></span></td>
                <td style="vertical-align: center; text-align: left; width:30%; border-top: 0; border-right: 0"><span>HARI</span></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:40%; border-left: 0; border-right: 0; border-top: 0; border-bottom: 0"><span style="padding-top: 0px;">dr. RUANGAN</span></td>
                <td style="vertical-align: top; text-align: left;width:40.5%; border-top: 0; border-left: 0; border-right: 0; border-bottom: 0"><span style="padding-top: 0px; border-bottom: 0"></span></td>
                <td style="vertical-align: top; text-align: right; width:30%; border-top: 0; border-right: 0; border-left: 0; border-bottom: 0"><span>DPJP</span></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="bordered-table" cellspacing="0">
        <tbody>
            <tr style="height: 60px">
                <td style="vertical-align: top; text-align: left;width:40%; border-left: 0; border-right: 0; border-top: 0; border-bottom: 0">{{@$pasien->NmDoc}}</td>
                <td style="vertical-align: top; text-align: left;width:40.5%; border-top: 0; border-left: 0; border-right: 0; border-bottom: 0"><span style="padding-top: 0px; border-bottom: 0"></span></td>
                <td style="vertical-align: top; text-align: right; width:30%; border-top: 0; border-right: 0; border-left: 0; border-bottom: 0">{{@$pasien->KdDPJP}}</td>
            </tr>
        </tbody>
    </table>

</body> 