<div class="tab-pane fade show active" id="nav-home3" role="tabpanel"
aria-labelledby="nav-home-tab">
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
                        @forelse ($hki as  $dataHki)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($dataHki->nama_hki) }}</td>
                                <td>{{ $dataHki->nomor_sertifikat }}</td>
                                <td>{{ \Carbon\Carbon::parse($dataHki->tgl_mulai_berlaku)->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($dataHki->tgl_berakhir)->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ $dataHki->jenis_hki->nama_jenis_hki }}</td>
                                <td>{{ $dataHki->jenis_ciptaan->jenis_ciptaan }}</td>
                                <td><a
                                        href="{{ asset('storage/' . $dataHki->files->path) }}">Download
                                        File Bukti</a></td>
                                <td>
                                    @if ($dataHki->status_validasi == '3')
                                        <span class="badge badge-warning"><i>Menunggu
                                                Verifikasi Operator</i></span>
                                    @elseif($dataHki->status_validasi == '1')
                                        <span class="badge badge-info"><i>Menunggu
                                                Verifikasi Wakil Dekan</i></span>
                                    @elseif($dataHki->status_validasi == '4')
                                        <span class="badge badge-success">diValidasi</span>
                                    @elseif($dataHki->status_validasi == '2')
                                        <span class="badge badge-danger"><i>di
                                                Tolak</i></span>
                                        <p class="italic"> Pesan : {{ $dataHki->pesan }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle"
                                            type="button" id="triggerId"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Proses
                                        </button>
                                        <div class="dropdown-menu"
                                            aria-labelledby="triggerId">
                                            <a class="dropdown-item"
                                                href="{{ route('karya-mahasiswa.show', ['hki', encrypt($dataHki->id_hki_mahasiswa)]) }}"><i
                                                    class="fa fa-info"
                                                    aria-hidden="true"></i>
                                                Detail</a>
                                            @if (in_array($dataHki->status_validasi, ['3', '2']))
                                                <a class="dropdown-item"
                                                    href="{{ route('karyaMahasiswa.edit', ['hki', $dataHki->id_hki_mahasiswa]) }}"><i
                                                        class="fas fa-edit"
                                                        aria-hidden="true"></i>
                                                    Ubah</a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="destroy('hapusData{{ $dataHki->id_hki_mahasiswa }}')"><i
                                                        class="fas fa-trash"
                                                        aria-hidden="true"></i>
                                                    Hapus
                                                </a>
                                                <form method="post"
                                                    action="{{ route('karya-mahasiswa.destroy', encrypt($dataHki->id_hki_mahasiswa)) }}"
                                                    id="hapusData{{ $dataHki->id_hki_mahasiswa }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="jenis"
                                                        value="hki">
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
