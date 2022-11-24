<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @include('partials.detail-button-header', ['data' => $data,'type'=>$type])
            </div>
            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th class="bg-teal-400">Nama</th>
                                            <td>:</td>
                                            <td class="bg-lime-400 font-bold text-xl">{{ $data->mhspt->mahasiswa->nama_mahasiswa }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-teal-400">NIM</th>
                                            <td>:</td>
                                            <td class="bg-blue-400 font-bold text-lg">{{ $data->mhspt->no_mhs }}</td>
                                        </tr>
                                        <tr>
                                            <th>Program Studi</th>
                                            <td>:</td>
                                            <td>{{$data->mhspt->prodi->nama_prodi}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td>:</td>
                                            <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->isoFormat('dddd, D MMMM Y')}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>:</td>
                                            <td>{{\Carbon\Carbon::parse($data->selesai)->isoFormat('dddd, D MMMM Y')}}</td>
                                        </tr>
                                        <tr>
                                            <th>Dosen Pembimbing</th>
                                            <td>:</td>
                                            <td>
                                            @if ($data->kepeg_pegawai()->exists())
                                                {{ $data->kepeg_pegawai->nip }} - {{ Helper::nama_gelar($data->kepeg_pegawai) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-teal-400">Status Validasi</th>
                                            <td>:</td>
                                            <td class="
                                                    @if ($data->status_validasi == '3')
                                                      bg-orange-300
                                                    @elseif($data->status_validasi == '1')
                                                        bg-blue-300
                                                    @elseif($data->status_validasi == '4')
                                                        bg-green-300
                                                    @elseif($data->status_validasi == '2')
                                                        bg-red-300
                                                    @endif
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
                                                <p class="italic"> Pesan : {{$data->pesan}}</p>
                                            @endif
                                        </td>
                                        </tr>
                                        <tr>
                                            <th>Penyelenggara</th>
                                            <td>:</td>
                                            <td>{{ $data->penyelenggara()->exists() ? $data->penyelenggara->nama : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tingkat</th>
                                            <td>:</td>
                                            <td>{{ $data->tingkat()->exists() ? $data->tingkat->nama : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Prestasi</th>
                                            <td>:</td>
                                            <td>{{ $data->prestasi()->exists() ? $data->prestasi->nama : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bobot</th>
                                            <td>:</td>
                                            <td>{{$data->bobot_nilai->bobot}}</td>
                                        </tr>
                                        <tr>
                                            <th>Download Dokumen</th>
                                            <td>:</td>
                                            <td>
                                                <div class="row">
                                                    @if ($data->files()->exists())
                                                        <div class="col-md-6">
                                                            <object height="100%" width="100%" data="{{ asset('storage/' . $data->files->path) }}" type="application/pdf">
                                                                <iframe height="100%" width="100%" src="https://docs.google.com/viewer?url={{ asset('storage/' . $data->files->path) }}&embedded=true"></iframe>
                                                            </object>
                                                            <a href="{{ asset('storage/' . $data->files->path) }}"
                                                                class="btn btn-sm btn-info text-white"><i class="fa fa-download"
                                                                    aria-hidden="true"></i> Download File Sertifikat</a>
                                                        </div>
                                                    @endif
                                                    @if (method_exists($data, 'file_sk'))
                                                        @if ($data->file_sk()->exists())
                                                            <div class="col-md-6">
                                                                <object height="100%" width="100%" data="{{ asset('storage/' . $data->file_sk->path) }}" type="application/pdf">
                                                                    <iframe height="100%" width="100%" src="https://docs.google.com/viewer?url={{ asset('storage/' . $data->file_sk->path) }}&embedded=true"></iframe>
                                                                </object>
                                                                <a href="{{ asset('storage/' . $data->file_sk->path) }}"
                                                                    class="btn btn-sm btn-info text-white"><i class="fa fa-download"
                                                                        aria-hidden="true"></i> Download File SK</a>
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
                        <div class="row pt-5 mb-5 pb-10 justify-content-center bg-slate-800 shadow-sm">
                            @if ($type == 'operator')
                            @if (in_array($data->status_validasi, ['2', '3']))
                                <div class="col-2">
                                    <a name="" id="" class="btn btn-success btn-lg"
                                        onclick="konfirmasi('update'+{{ $data->id_hki_mahasiswa }}+'karya','Apakah Anda Yakin ingin Menvalidasi data ini ?');"
                                        href="#" role="button">Validasi</a>
                                    <form
                                        action="{{ route('validasi.update', ['karya', $data->id_hki_mahasiswa]) }}"
                                        id="update{{ $data->id_hki_mahasiswa . 'karya' }}" method="post">
                                        @csrf
                                        @method('put')
                                    </form>
                                </div>
                            @endif
                            @if (in_array($data->status_validasi, ['1', '3']))
                                <div class="col-2">
                                    <a name="" id="" onclick="tolakModal(this);"
                                        data-url="{{ route('validasi.destroy', ['karya', $data->id_hki_mahasiswa]) }}"
                                        class="btn btn-danger btn-lg" href="#" role="button">Tolak</a>
                                </div>
                            @endif
                        @elseif($type == 'wadek')
                            <div class="col-2">
                                <a name="" id="" class="btn btn-success btn-lg"
                                    onclick="konfirmasi('update'+{{ $data->id_hki_mahasiswa }}+'karya','Apakah Anda Yakin ingin Menvalidasi data ini ?');"
                                    href="#" role="button">Validasi</a>
                                <form
                                    action="{{ route('validasi-wadek.update', ['karya', $data->id_hki_mahasiswa, $data->siakad_mhspt_id]) }}"
                                    id="update{{ $data->id_hki_mahasiswa . 'karya' }}" method="post">
                                    @csrf
                                    @method('put')
                                </form>
                            </div>
                            <div class="col-2">
                                <a name="" id="" onclick="tolakModal(this);"
                                    data-url="{{ route('validasi-wadek.destroy', ['karya', $data->id_hki_mahasiswa]) }}"
                                    class="btn btn-danger btn-lg" href="#" role="button">Tolak</a>
                            </div>
                        @endif
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="nav-home">
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
