<div class="tab-pane fade" id="nav-profile2" role="tabpanel" aria-labelledby="nav-profile-tab">
    <form action="{{ route('karya-mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="jenis" value="publikasi">
                <div class="form-group">
                    <label for="">Judul Publikasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="judul" id="" aria-describedby="helpId"
                        placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Terbit <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tgl_terbit" id=""
                        aria-describedby="helpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="penerbit" id="" aria-describedby="helpId"
                        placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Jenis Publikasi <span class="text-danger">*</span></label>
                    <select class="form-control" style="width: 100%" name="jenis_id" id="jenis-publikasi">
                        @foreach (Helper::jenis_publikasi() as $jenis_publikasi)
                            <option value="{{ $jenis_publikasi->id_jenis }}">
                                {{ $jenis_publikasi->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Kategori Capaian <span class="text-danger">*</span></label>
                    <select class="form-control" style="width: 100%" name="kategori_capaian_id" id="kategori-capaian">
                        @foreach (Helper::kategori_capaian() as $kategori_capaian)
                            <option value="{{ $kategori_capaian->id_kategori_capaian }}">
                                {{ $kategori_capaian->nama_kategori_capaian }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Link Publikasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tautan_eksternal" id=""
                        aria-describedby="helpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">File Bukti <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" name="file" id="" placeholder=""
                        aria-describedby="fileHelpId">
                    <span class="text-muted italic">File docx,pdf,jpg,png ( Maks.
                        5MB)</span>
                </div>
            </div>
            @if (Auth::user()->siakad_mhspt()->exists())
                <div class="card-footer">
                    <button type="submit"
                        class="btn btn-wide btn-success">Simpan</button>
                </div>
            @endif
    </form>
</div>
