<div class="tab-pane fade show active" id="nav-profile3" role="tabpanel" aria-labelledby="nav-profile-tab">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive" data-theme="bumblebee">
                    <table class="table table-bordered table-stripped" id="tabelPublikasi">
                        <thead>
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
                            @forelse ($data as $dataPublikasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($dataPublikasi->relasi->nama) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($dataPublikasi->relasi->tgl_terbit) }}
                                    </td>
                                    <td>{{ $dataPublikasi->relasi->penerbit }}</td>
                                    <td>{{ $dataPublikasi->relasi->jenis_publikasi->nama_jenis ?? '-' }}</td>
                                    <td>{{ $dataPublikasi->relasi->kategori_capaian->nama_kategori_capaian ?? '-' }}
                                    </td>
                                    <td>{{ $dataPublikasi->relasi->tautan_eksternal }}</td>
                                    <td><a href="{{ asset('storage/' . $dataPublikasi->file->path) }}">Download
                                            File Bukti</a></td>
                                    <td>
                                        @if ($dataPublikasi->validasi == '3')
                                            <span class="badge badge-warning"><i>Menunggu
                                                    Verifikasi Operator</i></span>
                                        @elseif($dataPublikasi->validasi == '1')
                                            <span class="badge badge-info"><i>Menunggu
                                                    Verifikasi Wakil Dekan</i></span>
                                        @elseif($dataPublikasi->validasi == '4')
                                            <span class="badge badge-success">diValidasi</span>
                                        @elseif($dataPublikasi->validasi == '2')
                                            <span class="badge badge-danger"><i>di
                                                    Tolak</i></span>
                                            <p class="italic"> Pesan :
                                                {{ $dataPublikasi->pesan }}</p>
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
                                                    href="{{ route('kegiatan.lihat', encrypt($dataPublikasi->id_publikasi)) }}"><i
                                                        class="fa fa-info" aria-hidden="true"></i>
                                                    Detail</a>
                                                @if (in_array($dataPublikasi->validasi, ['3', '2']))
                                                    <a class="dropdown-item"
                                                        href="{{ route('kegiatan.edit', encrypt($dataPublikasi->id)) }}"><i
                                                            class="fas fa-edit" aria-hidden="true"></i>
                                                        Ubah</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="destroy('hapusDataPublikasi{{ $dataPublikasi->id }}')"><i
                                                            class="fas fa-trash" aria-hidden="true"></i>
                                                        Hapus
                                                    </a>
                                                    <form method="post"
                                                        action="{{ route('kegiatan.destroy', encrypt($dataPublikasi->id)) }}"
                                                        id="hapusDataPublikasi{{ $dataPublikasi->id }}">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="jenis" value="publikasi">
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
