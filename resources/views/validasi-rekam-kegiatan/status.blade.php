@if ($row['validasi'] == '3')
    <span class="text-black badge badge-warning"><i>{{ucwords(__("message.valid.operator"))}}</i></span>
@elseif ($row['validasi'] == '1')
    <span class="text-white badge badge-info"><i>{{ucwords(__("message.valid.wadek"))}}</i></span>
@elseif ($row['validasi'] == '4')
    <span class="text-white badge badge-success"><i>{{ucwords(__("message.success.valid"))}}</i></span>
@elseif ($row['validasi'] == '2')
    <span class="text-white badge badge-danger"><i>{{ucwords(__("message.failed.notValid"))}}</i></span>
    <p class="italic">Pesan : {{$row['pesan']}}</p>
@endif
