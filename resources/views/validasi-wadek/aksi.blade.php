<div class="dropdown z-0">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Proses
    </button>
    <div class="dropdown-menu z-50" aria-labelledby="triggerId">

        {{-- Validasi Form --}}
            {{-- <a class="dropdown-item text-success"
                onclick="konfirmasi('update'+{{ $row['id'] }}+'{{ $row['jenis_kegiatan'] }}','Apakah Anda Yakin ingin Menvalidasi data ini ?');"
                href="#"><i class="fa fa-check" aria-hidden="true"></i> Validasi</a>
            <form action="{{ route('validasi-wadek.update', [$row['jenis_kegiatan'],$row['id'],$row['siakad_mhspt_id']]) }}"
                id="update{{ $row['id'] . $row['jenis_kegiatan'] }}" method="post">
                @csrf
                @method('put')
            </form> --}}

        {{-- Tolak Form --}}
            {{-- <a class="dropdown-item text-danger"
                onclick="tolak('hapus'+{{ $row['id'] }}+'{{ $row['jenis_kegiatan'] }}','Bukti kegiatan tidak cocok dengan data yang di masukan');"
                href="#"><i class="fa fa-times" aria-hidden="true"></i> Tolak</a>
            <form action="{{ route('validasi-wadek.destroy', [$row['jenis_kegiatan'], $row['id']]) }}"
                id="hapus{{ $row['id'] . $row['jenis_kegiatan'] }}" method="post">
                @csrf
                @method('delete') --}}
            {{-- </form> --}}

        {{-- Detail Form --}}
        <a class="dropdown-item" href="{{route('validasi.show',[$row['id'],$row['jenis_kegiatan'],'wadek'])}}">
            <i class="fa fa-info" aria-hidden="true"></i> Detail
        </a>
    </div>
</div>
