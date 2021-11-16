@extends('layouts.main')
@section('title','Print Tracer | Modul Registrasi')
@section('menu-min','menu-min')
@section('monitoring_status','active')
@section('tracer','active')
@section('header','Print Tracer')

@section('content')
<style type="text/css">
  #tracerList td {
    border: 1px solid #00000037;
    padding: 5px;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-body no-padding">
        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="widget-box">
            <div class="widget-header widget-header-flat">
              <h4 class="widget-title smaller">Tracer Harian</h4>

              <div class="widget-toolbar">
                <label>
                  <small class="green">
                    <b>Auto Print</b>
                  </small>

                  <input type="checkbox" id="autoPrint" class="ace ace-switch ace-switch-6" value="1" autocomplete="off">
                  <span class="lbl middle"></span>
                </label>
              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main">
                <div class="row">
                  <div class="col-md-4">
                    <form id="formTracer" class="form-horizontal" autocomplete="off">
                      <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right"> Poli </label>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <select name="poli" class="form-control select2">
                              <option value="" disabled="disabled" selected="selected"></option>
                              @foreach($list_poli as $item)
                                <?php $selected = $item->KDPoli == $poli ? 'selected="selected"' : ''; ?>
                                <option value="{{ $item->KDPoli }}" <?= $selected ?>>{{ $item->NMPoli }}</option>
                              @endforeach
                            </select>
                            <span class="input-group-btn">
                              <button type="button" id="clearPoliBtn" class="btn btn-xs">
                                <i class="fa fa-times"></i>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right"> Tanggal </label>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <input type="text" name="tanggal" class="form-control datepicker" value="{{ $tanggal }}">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-search"></i> Cari
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="row"><div class="col-md-12"><hr></div></div>
                <div class="row">
                  <div class="col-md-8" style="overflow: auto; height: 400px;">
                    <table id="tracerList" class="table table-bordered">
                      <thead>
                        <tr class="info">
                          <th style="width: 60px;">No.</th>
                          <th style="width: 100px;">No. Antrian</th>
                          <th style="width: 120px;">No. Registrasi</th>
                          <th style="width: 100px;">No. RM</th>
                          <th>Nama</th>
                          <th>Poli</th>
                          <th style="width: 50px;">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        @include('tracer/harian--table-rows')
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                    <div id="tracerPreview"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(function() {
    $('.datepicker').datepicker({format: 'yyyy-mm-dd', todayHighlight: true, endDate: '0d'});
    $('.select2').select2();
    $('#clearPoliBtn').click(function() {
      $('[name=poli]').val(null).trigger('change');
    });

    let tanggal = '{{ $tanggal }}';
    let poli = '{{ $poli }}';
    let last_number = {{ count($list_tracer) }};
    let last_regno = '{{ empty($list_tracer) ? '' : $list_tracer[count($list_tracer) - 1]->Regno }}';
    let last_time = '{{ empty($list_tracer) ? '' : $list_tracer[count($list_tracer) - 1]->Regtime }}';
    let enableAutoPrint;

    let dataQueue = [];

    function printTracer(regno) {
      let force_print;

      if(typeof regno === 'undefined') {
        let entry = dataQueue.shift();
        force_print = entry.force_print;
        regno = entry.regno;
      }
      else {
        force_print = true;
      }

      $('#tracerPreview').html(`
        <div class="alert alert-info">
          Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span>
        </div>
      `);
      $.ajax({
        method: 'GET',
        url: '{{ route('tracer-print-markup') }}',
        data: {regno, force_print},
        success: function(res) {
          $('#tracerPreview').html(res.markup);
          setTimeout(function() {
            if(res.shouldPrint) {
              $('#tracerPreview').printThis({
                afterPrint: function() {
                  $.ajax({
                    method: 'POST',
                    url: '{{ route('tracer-set-print-status') }}',
                    data: {regno},
                    success: function() {
                      $(`#tracerList [data-regno=${regno}]`).removeClass('danger').data('printed', 1).attr('data-printed', 1);
                      if(enableAutoPrint) {
                        setTimeout(function() {
                          printQueue();
                        }, 700);
                      }
                    },
                    error: function() {
                      let params = this;
                      setTimeout(function() {
                        $.ajax(params);
                      }, 500);
                    }
                  });
                }
              });
            }
            else {
              $(`#tracerList [data-regno=${regno}]`).removeClass('danger').data('printed', 1).attr('data-printed', 1);
              if(enableAutoPrint) printQueue(); 
            }
          }, 300);
        },
        error: function() {
          let params = this;
          setTimeout(function() {
            $.ajax(params);
          }, 500);
        }
      });
    }

    function printQueue() {
      if(dataQueue.length) {
        printTracer();
      }
      else {
        setTimeout(function() {
          $.ajax({
            type: 'GET',
            url: '{{ route('tracer-table-rows') }}',
            data: {tanggal, poli, last_regno, last_time, last_number},
            success: function(res) {
              if(res) {
                $('#tracerList tbody').append(res);
                let selector = $('#tracerList tbody tr:last-child');
                last_number = selector.data('number');
                last_regno = selector.data('regno');
                last_time = selector.data('regtime');
              }

              if(enableAutoPrint) startAutoPrint();
            },
            error: function() {
              let params = this;
              setTimeout(function() {
                $.ajax(params);
              }, 500);
            }
          });
        }, 5000);
      }
    }

    function startAutoPrint() {

      $('#tracerList [data-printed=0]').each(function(i, item) {
        dataQueue.push({regno: $(item).data('regno'), force_print: false});
      });

      printQueue();
    }

    $('#autoPrint').on('input', function() {
      enableAutoPrint = $(this).prop('checked');
      if(enableAutoPrint) {
        startAutoPrint();
      }
    }).trigger('input');

    $('#tracerList tbody').on('click', '.print-btn', function() {
      let regno = $(this).parents('tr').data('regno');
      if(enableAutoPrint) {
        dataQueue.unshift({regno, force_print: true});
      }
      else {
        printTracer(regno);
      }
    });
  });
</script>
@endsection