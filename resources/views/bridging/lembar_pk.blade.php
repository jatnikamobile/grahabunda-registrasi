@extends('layouts.main')
@section('title','Bridging BPJS | Lembar Pengajuan Klaim')
@section('bridging','active')
@section('lembar_pk','active')
@section('header','Lembar Pengajuan Klaim')

@section('content')
<section>
	<div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
			<li class="active">
				<a data-toggle="tab" href="#list-lpk">List Lembar Pengajuan Klaim</a>
			</li>
			<li>
				<a data-toggle="tab" href="#data-lpk">Data Lembar Pengajuan Klaim</a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="list-lpk" class="tab-pane in active">
				@include('bridging.lpk.list')
			</div>
			<div id="data-lpk" class="tab-pane in">
				@include('bridging.lpk.data')
			</div>
		</div>
	</div>
</section>
@endsection

@section('script')
@stack('script-stack')
@endsection