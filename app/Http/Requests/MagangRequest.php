<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama' => [
                'required',
                'string'
            ],
            'judul_laporan_akhir' => [
                'nullable',
                'string'
            ],
            'tugas_utama_magang' => [
                'nullable',
                'string'
            ],
            'nama_eng' => [
                'string'
            ],
            'file_id' => [
                'required_without:file_kegiatan_id',
                'mimes:pdf,docs',
                'max:5000'
            ],
            'kepeg_pegawai_id' => [
                'nullable',
                'string'
            ],
            'ref_bidang_id' => [
                'required',
                'string'
            ],
            'ref_divisi_id' => [
                'required',
                'string'
            ],
            'file_kegiatan_id' => [
                'string',
                'nullable'
            ],
            'file_kegiatan_ref_jenis_kegiatan_id' => [
                'string',
                'nullable'
            ],
            'status_validasi' => [
                'string',
                'nullable'
            ],
            'pesan' => [
                'string',
                'nullable'
            ],
            'validator_id' => [
                'string',
                'nullable'
            ],
            'tgl_mulai' => [
                'date',
            ],
            'tgl_selesai' => [
                'date',
                'after_or_equal:tgl_mulai'
            ]
        ];
    }
}
