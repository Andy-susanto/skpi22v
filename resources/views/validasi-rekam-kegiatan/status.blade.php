@if ($row['validasi'] == '3')
    <span class="text-black badge badge-warning"><i>{{ucword(@lang("message.valid.operator"))}}</i></span>
@elseif ($row['validasi'] == '1')
    <span class="text-white badge badge-info"><i>{{ucowrd(@lang("message.valid.wadek"))}}</i></span>
@elseif ($row['validasi'] == '4')
    <span class="text-white badge badge-success"><i>{{ucword(@lang("message.success.valid"))}}</i></span>
@elseif ($row['validasi'] == '2')
    <span class="text-white badge badge-danger"><i>{{ucowrd(@lang("message.failed.notValid"))}}</i></span>
    <p class="italic">Pesan : {{$row['pesan']}}</p>
@endif
