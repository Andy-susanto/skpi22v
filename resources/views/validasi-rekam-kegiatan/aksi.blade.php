<div class="dropdown z-0">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Proses
    </button>
    <div class="dropdown-menu z-50" aria-labelledby="triggerId">

        {{-- Validasi Form --}}
        @if (in_array($row['validasi'], ['2', '3']))
            <a class="dropdown-item text-success"
                onclick="konfirmasi('update'+{{ $row['id'] }}+'{{ $row['jenis_kegiatan'] }}','Apakah Anda Yakin ingin Menvalidasi data ini ?');"
                href="#"><i class="fa fa-check" aria-hidden="true"></i> Validasi</a>
            <form action="{{ route('validasi.update', [$row['jenis_kegiatan'], $row['id']]) }}"
                id="update{{ $row['id'] . $row['jenis_kegiatan'] }}" method="post">
                @csrf
                @method('put')
            </form>
        @endif
        {{-- Tolak Form --}}
        @if (in_array($row['validasi'], ['1', '3']))
            <a class="dropdown-item tolak text-danger" onclick="tolakModal(this);" data-url="{{ route('validasi.destroy', [$row['jenis_kegiatan'], $row['id']]) }}"><i class="fa fa-times" aria-hidden="true"></i> Tolak</a>
        @endif

        {{-- Detail Form --}}
        <a class="dropdown-item" href="{{route('validasi.show',[$row['id'],$row['jenis_kegiatan']])}}">
            <i class="fa fa-info" aria-hidden="true"></i> Detail
        </a>
    </div>
</div>
