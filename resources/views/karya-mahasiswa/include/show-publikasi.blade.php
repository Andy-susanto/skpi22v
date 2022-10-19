<div class="tab-pane fade" id="nav-profile3" role="tabpanel"
aria-labelledby="nav-profile-tab">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive" data-theme="bumblebee">
                <table class="table table-bordered table-stripped" id="tabelPublikasi">
                    <thead >
                        <tr>
                            <th>#</th>
                            <th>Judul Publikasi</th>
                            <th>Tanggal Terbit</th>
                            <th>Penerbit</th>
                            <th>Jenis Publikasi</th>
                            <th>Kategori Capaian</th>
                            <th>Link Publikasi</th>
                            <th>File Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($publikasi as $dataPublikasi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($dataPublikasi->judul) }}</td>
                                <td>{{ \Carbon\Carbon::parse($dataPublikasi->tgl_terbit) }}
                                </td>
                                <td>{{ $dataPublikasi->penerbit }}</td>
                                <td>{{ $dataPublikasi->jenis_publikasi->nama_jenis }}</td>
                                <td>{{ $dataPublikasi->kategori_capaian->nama_kategori_capaian }}
                                </td>
                                <td>{{ $dataPublikasi->tautan_eksternal }}</td>
                                <td><a
                                        href="{{ asset('storage/' . $dataPublikasi->files->path) }}">Download
                                        File Bukti</a></td>
                                <td>
                                    @if ($dataPublikasi->status_validasi == '3')
                                        <span class="badge badge-warning"><i>Menunggu
                                                Verifikasi Operator</i></span>
                                    @elseif($dataPublikasi->status_validasi == '1')
                                        <span class="badge badge-info"><i>Menunggu
                                                Verifikasi Wakil Dekan</i></span>
                                    @elseif($dataPublikasi->status_validasi == '4')
                                        <span class="badge badge-success">diValidasi</span>
                                    @elseif($dataPublikasi->status_validasi == '2')
                                        <span class="badge badge-danger"><i>di
                                                Tolak</i></span>
                                        <p class="italic"> Pesan :
                                            {{ $dataPublikasi->pesan }}</p>
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
                                                href="{{ route('karya-mahasiswa.show', ['publikasi', encrypt($dataPublikasi->id_publikasi)]) }}"><i
                                                    class="fa fa-info"
                                                    aria-hidden="true"></i>
                                                Detail</a>
                                            @if (in_array($dataPublikasi->status_validasi, ['3', '2']))
                                                <a class="dropdown-item"
                                                    href="{{ route('karyaMahasiswa.edit', ['publikasi', encrypt($dataPublikasi->id_publikasi)]) }}"><i
                                                        class="fas fa-edit"
                                                        aria-hidden="true"></i>
                                                    Ubah</a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="destroy('hapusDataPublikasi{{ $dataPublikasi->id_publikasi }}')"><i
                                                        class="fas fa-trash"
                                                        aria-hidden="true"></i>
                                                    Hapus
                                                </a>
                                                <form method="post"
                                                    action="{{ route('karya-mahasiswa.destroy', encrypt($dataPublikasi->id_publikasi)) }}"
                                                    id="hapusDataPublikasi{{ $dataPublikasi->id_publikasi }}">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="jenis"
                                                        value="publikasi">
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
