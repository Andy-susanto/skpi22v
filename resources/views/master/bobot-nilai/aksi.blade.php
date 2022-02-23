<div class="dropdown open">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="triggerId"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-tasks" aria-hidden="true"></i> Proses
    </button>
    <div class="dropdown-menu" aria-labelledby="triggerId">
        <a class="dropdown-item ubah-data" href="#modalUbah" data-toggle="modal" data-update="{{route('bobot-nilai.update',encrypt($row->id_bobot_nilai))}}" data-edit="{{route('bobot-nilai.edit',encrypt($row->id_bobot_nilai))}}"><i class="fa fa-edit"aria-hidden="true"></i> Ubah</a>

        <a class="dropdown-item" onclick="confirmation('bobot_{{$row->id_bobot_nilai}}')"><i class="fa fa-trash" aria-hidden="true" ></i> Hapus
            <form action="{{route('bobot-nilai.destroy',encrypt($row->id_bobot_nilai))}}" method="post" id="bobot_{{$row->id_bobot_nilai}}">
                @csrf
                @method('delete')
            </form>
        </a>
    </div>
</div>
