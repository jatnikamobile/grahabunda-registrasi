@if(empty($list_tracer))
<tr><td colspan="100%" style="text-align: center; font-style: italic;">(Tidak ada data)</td></tr>
@else
<?php $no = $last_number ?? 0; ?>
@foreach($list_tracer as $item)
  <tr class="{{ $item->DiPrint ? '' : 'danger' }}"
    data-number="{{ ++$no }}"
    data-regno="{{ $item->Regno }}"
    data-regtime="{{ $item->Regtime }}"
    data-printed="<?= isset($item->DiPrint) ? '1' : '0' ?>">
    <td>{{ $no }}</td>
    <td>{{ $item->NomorUrut }}</td>
    <td>{{ $item->Regno }}</td>
    <td>{{ $item->Medrec }}</td>
    <td>{{ $item->Firstname }}</td>
    <td>{{ $item->NmPoli }}</td>
    <td>
      <button class="btn btn-minier btn-round print-btn">
        <i class="fa fa-print"></i>
      </button>
    </td>
  </tr>
@endforeach
@endif