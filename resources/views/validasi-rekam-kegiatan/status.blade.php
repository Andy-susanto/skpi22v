@if ($row['validasi'] == '3')
    <span class="text-black badge badge-warning"><i>Menunggu Validasi Operator</i></span>
@elseif ($row['validasi'] == '1')
    <span class="text-white badge badge-info"><i>Menunggu Validasi Wakil Dekan</i></span>
@elseif ($row['validasi'] == '4')
    <span class="text-white badge badge-success"><i>di Validasi</i></span>
@elseif ($row['validasi'] == '2')
    <span class="text-white badge badge-danger"><i>Tidak di Terima</i></span>
@endif
