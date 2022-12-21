<div class="tab-pane fade show active" id="nav-home2" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="card">
        <form action="{{ route('kegiatan.store') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ref_jenis_kegiatan_id" value="{{ config('kegiatan.HKI') }}">
            @csrf
            <div class="card-body">
                <input type="hidden" name="jenis" value="hki">
                <div class="form-group">
                    <label for="">Nama HKI <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_hki" id="" aria-describedby="helpId"
                        placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Nomor Sertifikat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nomor_sertifikat" id=""
                        aria-describedby="helpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Mulai Berlaku <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tgl_mulai_berlaku" id=""
                        aria-describedby="helpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Berakhir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tgl_berakhir" id=""
                        aria-describedby="helpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Jenis HKI <span class="text-danger">*</span></label>
                    <select class="form-control" name="jenis_hki_id" id="">
                        @foreach (Helper::jenis_hki() as $jenis_hki)
                            <option value="{{ $jenis_hki->id_jenis_hki }}">
                                {{ $jenis_hki->nama_jenis_hki }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Jenis Ciptaan <span class="text-danger">*</span></label>
                    <select class="form-control" name="jenis_ciptaan_id" id="">
                        @foreach (Helper::jenis_ciptaan() as $jenis_ciptaan)
                            <option value="{{ $jenis_ciptaan->id_jenis_ciptaan }}">
                                {{ $jenis_ciptaan->jenis_ciptaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">File Bukti <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" name="file" placeholder=""
                        aria-describedby="fileHelpId">
                    <span class="text-muted italic">File docx,pdf,jpg,png ( Maks.
                        5MB)</span>
                </div>
            </div>
            @if (Auth::user()->siakad_mhspt()->exists())
                <div class="card-footer">
                    <button type="submit" class="btn btn-wide btn-success">Simpan</button>
                </div>
            @endif
        </form>
    </div>
</div>
