<div class="tab-pane fade show active" id="nav-home3" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive" data-theme="bumblebee">
                    <table class="table table-bordered table-stripped" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama HKI</th>
                                <th>Nomor Sertifikat</th>
                                <th>Tanggal Mulai Berlaku</th>
                                <th>Tanggal Berakhir</th>
                                <th>Jenis HKI</th>
                                <th>Jenis Ciptaan</th>
                                <th>File Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as  $dataHki)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($dataHki->relasi->nama_hki) }}</td>
                                    <td>{{ $dataHki->relasi->nomor_sertifikat }}</td>
                                    <td>{{ \Carbon\Carbon::parse($dataHki->relasi->tgl_mulai_berlaku)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($dataHki->relasi->tgl_berakhir)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td>{{ $dataHki->relasi->jenis_hki->nama_jenis_hki }}</td>
                                    <td>{{ $dataHki->relasi->jenis_ciptaan->jenis_ciptaan }}</td>
                                    <td><a href="{{ asset('storage/' . $dataHki->file->path) }}">Download
                                            File Bukti</a></td>
                                    <td>
                                        @if ($dataHki->validasi == '3')
                                            <span class="badge badge-warning"><i>Menunggu
                                                    Verifikasi Operator</i></span>
                                        @elseif($dataHki->validasi == '1')
                                            <span class="badge badge-info"><i>Menunggu
                                                    Verifikasi Wakil Dekan</i></span>
                                        @elseif($dataHki->validasi == '4')
                                            <span class="badge badge-success">diValidasi</span>
                                        @elseif($dataHki->validasi == '2')
                                            <span class="badge badge-danger"><i>di
                                                    Tolak</i></span>
                                            <p class="italic"> Pesan : {{ $dataHki->pesan }}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Proses
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                <a class="dropdown-item"
                                                    href="{{ route('kegiatan.lihat', encrypt($dataHki->id)) }}"><i
                                                        class="fa fa-info" aria-hidden="true"></i>
                                                    Detail</a>
                                                @if (in_array($dataHki->validasi, ['3', '2']))
                                                    <a class="dropdown-item"
                                                        href="{{ route('kegiatan.edit', $dataHki->id) }}"><i
                                                            class="fas fa-edit" aria-hidden="true"></i>
                                                        Ubah</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="destroy('hapusData{{ $dataHki->id }}')"><i
                                                            class="fas fa-trash" aria-hidden="true"></i>
                                                        Hapus
                                                    </a>
                                                    <form method="post"
                                                        action="{{ route('kegiatan.destroy', encrypt($dataHki->id)) }}"
                                                        id="hapusData{{ $dataHki->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="jenis" value="hki">
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
