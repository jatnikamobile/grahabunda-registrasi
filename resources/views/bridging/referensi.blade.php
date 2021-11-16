@extends('layouts.main')
@section('title','Bridging BPJS | Referensi')
@section('bridging','active')
@section('referensi','active')
@section('header','Referensi')

@section('content')
<section>
	<div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
			<li class="active">
				<a data-toggle="tab" href="#diagnosa">Diagnosa</a>
			</li>
			<li>
				<a data-toggle="tab" href="#poli">Poli</a>
			</li>
			<li>
				<a data-toggle="tab" href="#faskes">Fasilitas Kesehatan</a>
			</li>
			<li>
				<a data-toggle="tab" href="#dokter_dpjp">Dokter DPJP</a>
			</li>
			<li>
				<a data-toggle="tab" href="#procedure">Procedure</a>
			</li>
			<li>
				<a data-toggle="tab" href="#kelas_rawat">Kelas Rawat</a>
			</li>
			<li>
				<a data-toggle="tab" href="#dokter">Dokter</a>
			</li>
			<li>
				<a data-toggle="tab" href="#spesialistik">Spesialistik</a>
			</li>
			<li>
				<a data-toggle="tab" href="#ruang_rawat">Ruang Rawat</a>
			</li>
			<li>
				<a data-toggle="tab" href="#cara_keluar">Cara Keluar</a>
			</li>
			<li>
				<a data-toggle="tab" href="#pasca_pulang">Pasca Pulang</a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="diagnosa" class="tab-pane in active">
				@include('bridging.referensi.diagnosa')
			</div>
			<div id="poli" class="tab-pane in">
				@include('bridging.referensi.poli')
			</div>
			<div id="faskes" class="tab-pane in">
				@include('bridging.referensi.faskes')
			</div>
			<div id="dokter_dpjp" class="tab-pane in">
				@include('bridging.referensi.dokter_dpjp')
			</div>
			<div id="procedure" class="tab-pane in">
				@include('bridging.referensi.procedure')
			</div>
			<div id="kelas_rawat" class="tab-pane in">
				@include('bridging.referensi.kelas_rawat')
			</div>
			<div id="dokter" class="tab-pane in">
				@include('bridging.referensi.dokter')
			</div>
			<div id="spesialistik" class="tab-pane in">
				@include('bridging.referensi.spesialistik')
			</div>
			<div id="ruang_rawat" class="tab-pane in">
				@include('bridging.referensi.ruang_rawat')
			</div>
			<div id="cara_keluar" class="tab-pane in">
				@include('bridging.referensi.cara_keluar')
			</div>
			<div id="pasca_pulang" class="tab-pane in">
				@include('bridging.referensi.pasca_pulang')
			</div>
		</div>
	</div>
</section>
@endsection

@section('script')
@stack('script-stack')
@endsection