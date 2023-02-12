<!-- menu-min -->
<div id="sidebar" class="sidebar sidebar-scroll sidebar-fixed hover responsive @yield('menu-min')" data-sidebar="true" data-sidebar-hover="false" data-sidebar-scroll="true">
    <script type="text/javascript">
        try{ace.settings.loadState('sidebar')}catch(e){}
    </script>
    <ul class="nav nav-list">
        <li class="@yield('menu_beranda')">
            <a href="{{ route('beranda') }}">
                <i class="menu-icon fa fa-home"></i><span class="menu-text"> Beranda </span>
            </a> <b class="arrow"></b>
        </li>
        <li class="@yield('menu_master_ps')">
            <a href="{{ route('mst-psn') }}">
                <i class="menu-icon fa fa-users"></i><span class="menu-text"> Master Pasien </span>
            </a> <b class="arrow"></b>
        </li>
        <li class="@yield('menu_surat_kontrol')">
            <a href="{{ route('srt-kntrl') }}">
                <i class="menu-icon fa fa-file"></i><span class="menu-text"> Surat Kontrol </span>
            </a> <b class="arrow"></b>
        </li>
        <li class="hover @yield('register')">
            <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-book"></i><span class="menu-text">Registrasi Pasien</span><b class="arrow fa fa-angle-down"></b></a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="hover @yield('pasien')">
                    {{-- RegistrasiUmum/Pendaftaran --}}
                    <a href="{{ route('register') }}"><i class="menu-icon fa fa-caret-right"></i>Semua Pasien</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('pasien_mcu')">
                    {{-- MutasiPasienUmum --}}
                    <a href="{{ route('register-mcu') }}"><i class="menu-icon fa fa-caret-right"></i>Pasien MCU</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('pasien_perjanjian')">
                    {{-- RegistrasiUmum/Pendaftaran --}}
                    <a href="{{ route('register-perjanjian') }}"><i class="menu-icon fa fa-caret-right"></i>Pasien Perjanjian</a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="hover @yield('register_umum')">
            <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-list-alt"></i><span class="menu-text">Registrasi Umum</span><b class="arrow fa fa-angle-down"></b></a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="hover @yield('daftar_ps_umum')">
                    {{-- RegistrasiUmum/Pendaftaran --}}
                    <a href="{{ route('reg-umum-daftar') }}"><i class="menu-icon fa fa-caret-right"></i>Registrasi Pasien Umum</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('mutasi_ps_umum')">
                    {{-- MutasiPasienUmum --}}
                    <a href="{{ route('reg-umum-mutasi') }}"><i class="menu-icon fa fa-caret-right"></i>Mutasi Pasien Umum</a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="hover @yield('bpjs')">
            <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-list-alt"></i><span class="menu-text">Registrasi BPJS</span><b class="arrow fa fa-angle-down"></b></a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="hover @yield('daftar_bpjs')">
                    {{-- Bpjs/Pendaftaran-bpjs --}}
                    <a href="{{ route('reg-bpjs-daftar') }}"><i class="menu-icon fa fa-caret-right"></i>Registrasi Pasien BPJS</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('mutasi_bpjs')">
                    {{-- Bpjs/Mutasi-pasien --}}
                    <a href="{{ route('reg-bpjs-mutasi') }}"><i class="menu-icon fa fa-caret-right"></i>Mutasi Pasien BPJS</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('rujukan_pasien')">
                    {{-- Bpjs/Rujukan-pasien --}}
                    <a href="{{ route('reg-bpjs-rujukan') }}"><i class="menu-icon fa fa-caret-right"></i>Rujukan Pasien</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('pengajuan_sep')">
                    {{-- Bpjs/Pengajuan-pasien-sep --}}
                    <a href="{{ route('reg-bpjs-pengajuan') }}"><i class="menu-icon fa fa-caret-right"></i>Pengajuan SEP (Back Date)</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('detail_sep')">
                    {{-- Bpjs/Detail-sep --}}
                    <a href="{{ route('reg-bpjs-detailsep') }}"><i class="menu-icon fa fa-caret-right"></i>Detail SEP</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('pengajuan_spri')">
                    {{-- Bpjs/Pengajuan SPRI --}}
                    <a href="{{ route('reg-bpjs-pengajuan-spri') }}"><i class="menu-icon fa fa-caret-right"></i>Pengajuan SPRI</a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="hover @yield('bridging')">
            <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-exchange"></i><span class="menu-text">Bridging BPJS</span><b class="arrow fa fa-angle-down"></b></a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="hover @yield('referensi')">
                    <a href="{{ route('bridging.referensi')}}"><i class="menu-icon fa fa-caret-right"></i>Referensi</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('daftar_kunjungan')">
                    <a href="{{ route('bridging.kunjungan')}}"><i class="menu-icon fa fa-caret-right"></i>Daftar Kunjungan</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('daftar_klaim')">
                    <a href="{{ route('bridging.klaim')}}"><i class="menu-icon fa fa-caret-right"></i>Daftar Klaim</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('suplesi')">
                    <a href="{{ route('bridging.suplesi')}}"><i class="menu-icon fa fa-caret-right"></i>Potensi Suplesi Jasa Raharja</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('histori_peserta')">
                    <a href="{{ route('bridging.histori_peserta')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Data Histori Pelayanan Peserta
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('klaim_jasa_raharja')">
                    <a href="{{ route('bridging.klaim_jasa_raharja')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Data Klaim Jasa Raharja
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('lpk')">
                    <a href="{{ route('bridging.lpk')}}"><i class="menu-icon fa fa-caret-right"></i>Lembar Pengajuan Klaim</a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="hover @yield('monitoring_status')">
            <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-line-chart"></i><span class="menu-text">Monitoring Status</span><b class="arrow fa fa-angle-down"></b></a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="hover @yield('tracer')">
                    {{-- Tracer --}}
                    <a href="{{ route('tracer') }}"><i class="menu-icon fa fa-caret-right"></i>Tracer</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('tracer-perjanjian')">
                    {{-- Tracer --}}
                    <a href="{{ route('tracer-perjanjian') }}"><i class="menu-icon fa fa-caret-right"></i>Tracer Perjanjian</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('status_tracer')">
                    {{-- Status Tracer --}}
                    <a href="{{ route('status-tracer') }}"><i class="menu-icon fa fa-caret-right"></i>Status Tracer</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('file_status_keluar')">
                    {{-- Monitoring-status/file-keluar --}}
                    <a href="{{ route('file-status-keluar') }}"><i class="menu-icon fa fa-caret-right"></i>File Status Keluar</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('file_status_masuk')">
                    {{-- Monitoring-status/file-masuk --}}
                    <a href="{{ route('file-status-masuk') }}"><i class="menu-icon fa fa-caret-right"></i>File Status Masuk</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('file_status_belum-kembali')">
                    {{-- Monitoring-status/file-status-belum-kembali --}}
                    <a href="{{ route('file-status-belum-kembali') }}"><i class="menu-icon fa fa-caret-right"></i>File Status Belum Kembali</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('monitoring_file_status')">
                    {{-- Monitoring-status/monitoring-file-status --}}
                    <a href="{{ route('monitoring-status') }}"><i class="menu-icon fa fa-caret-right"></i>Monitoring File Status</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover @yield('informasi_pasien_dirawat')">
                    {{-- Monitoring-status/informasi-pasien-dirawat' --}}
                    <a href="{{ route('informasi-pasien-dirawat') }}"><i class="menu-icon fa fa-caret-right"></i>Informasi Pasien Dirawat</a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="@yield('menu_tanggal_pulang')">
            <a href="{{ route('update-tanggal-pulang-list') }}">
                <i class="menu-icon fa fa-list-alt"></i><span class="menu-text"> Update Tgl Pulang </span>
            </a> <b class="arrow"></b>
        </li>
        {{-- <li class="hover">
            <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-bar-chart"></i><span class="menu-text">Laporan</span><b class="arrow fa fa-angle-down"></b></a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="hover">
                    <a href="{{ route('beranda')}}"><i class="menu-icon fa fa-caret-right"></i>Identitas Pasien</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover">
                    <a href="{{ route('beranda')}}"><i class="menu-icon fa fa-caret-right"></i>Registrasi Pasien</a>
                    <b class="arrow"></b>
                </li>
                <li class="hover">
                    <a href="{{ route('beranda')}}"><i class="menu-icon fa fa-caret-right"></i>Asal Rujukan</a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li> --}}
        <li class="@yield('menu_master_dokter')">
            <a href="{{ route('mst-dok.index') }}">
                <i class="menu-icon fa fa-users"></i><span class="menu-text"> Master Dokter </span>
            </a> <b class="arrow"></b>
        </li>
    </ul><!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
