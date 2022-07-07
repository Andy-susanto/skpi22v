@if ($row['validasi'] == '3')
    <span class="text-black badge badge-warning"><i>{{ucwords(@lang("message.valid.operator"))}}</i></span>
@elseif ($row['validasi'] == '1')
    <span class="text-white badge badge-info"><i>{{ucwords(@lang("message.valid.wadek"))}}</i></span>
@elseif ($row['validasi'] == '4')
    <span class="text-white badge badge-success"><i>{{ucwords(@lang("message.success.valid"))}}</i></span>
@elseif ($row['validasi'] == '2')
    <span class="text-white badge badge-danger"><i>{{ucwords(@lang("message.failed.notValid"))}}</i></span>
    <p class="italic">Pesan : {{$row['pesan']}}</p>
@endif
