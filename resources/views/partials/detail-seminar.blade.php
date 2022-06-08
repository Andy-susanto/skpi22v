<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @include('partials.detail-button-header', ['data' => $data])
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                            aria-controls="nav-home" aria-selected="true">Detail Validasi</a>
                        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                            aria-controls="nav-profile" aria-selected="false">Riwayat Kegiatan</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th class="bg-teal-400">Nama</th>
                                            <td>:</td>
                                            <td class="bg-lime-400 font-bold text-xl">
                                                {{ $data->mhspt->mahasiswa->nama_mahasiswa }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-teal-400">NIM</th>
                                            <td>:</td>
                                            <td class="bg-blue-400 font-bold text-lg">{{ $data->mhspt->no_mhs }}</td>
                                        </tr>
                                        <tr>
                                            <th>Program Studi</th>
                                            <td>:</td>
                                            <td>{{ $data->mhspt->prodi->nama_prodi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td>:</td>
                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->isoFormat('dddd, D MMMM Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>:</td>
                                            <td>{{ \Carbon\Carbon::parse($data->selesai)->isoFormat('dddd, D MMMM Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Dosen Pembimbing</th>
                                            <td>:</td>
                                            <td>
                                                @if ($data->kepeg_pegawai()->exists())
                                                    {{ $data->kepeg_pegawai->nip }} -
                                                    {{ Helper::nama_gelar($data->kepeg_pegawai) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-teal-400">Status Validasi</th>
                                            <td>:</td>
                                            <td
                                                class="
                                                @if ($data->status_validasi == '3') bg-orange-300
                                                @elseif($data->status_validasi == '1')
                                                    bg-blue-300
                                                @elseif($data->status_validasi == '4')
                                                    bg-green-300
                                                @elseif($data->status_validasi == '2')
                                                    bg-red-300 @endif
                                        ">
                                                @if ($data->status_validasi == '3')
                                                    <span class="badge badge-warning"><i>Menunggu Verifikasi
                                                            Operator</i></span>
                                                @elseif($data->status_validasi == '1')
                                                    <span class="badge badge-info"><i>Menunggu Verifikasi Wakil
                                                            Dekan</i></span>
                                                @elseif($data->status_validasi == '4')
                                                    <span class="badge badge-success">diValidasi</span>
                                                @elseif($data->status_validasi == '2')
                                                    <span class="badge badge-danger"><i>di Tolak</i></span>
                                                    <p class="italic"> Pesan : {{ $data->pesan }}</p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Penyelenggara</th>
                                            <td>:</td>
                                            <td>{{ $data->penyelenggara->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tingkat</th>
                                            <td>:</td>
                                            <td>{{ $data->tingkat->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Prestasi</th>
                                            <td>:</td>
                                            <td>{{ $data->peran_prestasi->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Download Dokumen</th>
                                            <td>:</td>
                                            <td>
                                                <div class="row">
                                                    @if ($data->files()->exists())
                                                        <div class="col-md-6">
                                                            <div id="sertifikat" style="height: 50vh"></div>
                                                            <a href="{{ asset('storage/' . $data->files->path) }}"
                                                                class="btn btn-sm btn-info text-white"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download File Sertifikat</a>
                                                        </div>
                                                    @endif
                                                    @if (method_exists($data,'file_sk'))
                                                    @if ($data->file_sk()->exists())
                                                        <div class="col-md-6">
                                                            <div id="file-sk" style="height: 50vh"></div>
                                                            <a href="{{ asset('storage/' . $data->file_sk->path) }}"
                                                                class="btn btn-sm btn-info text-white"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download File SK</a>
                                                        </div>
                                                    @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-striped">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>NO</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Nama Kegiatan / Judul</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Dosen Pembimbing</th>
                                    <th>Status</th>
                                    <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-5 mb-5 pb-10 justify-content-center bg-slate-800 shadow-sm">
    @if ($type == 'operator')
        @if (in_array($data->status_validasi, ['2', '3']))
            <div class="col-2">
                <a name="" id="" class="btn btn-success btn-lg"
                    onclick="konfirmasi('update'+{{ $data->id_seminar_pelatihan_workshop_diklat }}+'seminar','Apakah Anda Yakin ingin Menvalidasi data ini ?');"
                    href="#" role="button">Validasi</a>
                <form
                    action="{{ route('validasi.update', ['seminar', $data->id_seminar_pelatihan_workshop_diklat]) }}"
                    id="update{{ $data->id_seminar_pelatihan_workshop_diklat . 'seminar' }}" method="post">
                    @csrf
                    @method('put')
                </form>
            </div>
        @endif
        @if (in_array($data->status_validasi, ['1', '3']))
            <div class="col-2">
                <a name="" id="" onclick="tolakModal(this);"
                    data-url="{{ route('validasi.destroy', ['seminar', $data->id_seminar_pelatihan_workshop_diklat]) }}"
                    class="btn btn-danger btn-lg" href="#" role="button">Tolak</a>
            </div>
        @endif
    @elseif($type == 'wadek')
        <div class="col-2">
            <a name="" id="" class="btn btn-success btn-lg"
                onclick="konfirmasi('update'+{{ $data->id_seminar_pelatihan_workshop_diklat }}+'seminar','Apakah Anda Yakin ingin Menvalidasi data ini ?');"
                href="#" role="button">Validasi</a>
            <form
                action="{{ route('validasi-wadek.update', ['seminar', $data->id_seminar_pelatihan_workshop_diklat, $data->siakad_mhspt_id]) }}"
                id="update{{ $data->id_seminar_pelatihan_workshop_diklat . 'seminar' }}" method="post">
                @csrf
                @method('put')
            </form>
        </div>
        <div class="col-2">
            <a name="" id="" onclick="tolakModal(this);"
                data-url="{{ route('validasi-wadek.destroy', ['seminar', $data->id_seminar_pelatihan_workshop_diklat]) }}"
                class="btn btn-danger btn-lg" href="#" role="button">Tolak</a>
        </div>
    @endif
</div>
