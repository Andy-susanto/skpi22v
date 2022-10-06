<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganisasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'siakad_mhspt_id' => [
                'required',
                'string'
            ],
            'kepeg_pegawai_id' => [
                'string',
                'nullable'
            ],
            'ref_kategori_id' => [
                'required',
                'string'
            ],
            'ref_penyelenggara_id' => [
                'required',
                'string'
            ],
            'ref_peran_prestasi_id' => [
                'required',
                'string'
            ],
            'ref_tingkat_id' => [
                'required',
                'string'
            ],
            'bobot_nilai_id' => [
                'required',
                'string'
            ],
            'file' => [
                'required_without:file_kegiatan_id',
                'mimes:pdf,docs',
                'max:5000'
            ],
            'file_kegiatan_id' => [
                'string',
                'nullable'
            ],
            'file_kegiatan_ref_jenis_kegiatan_id' => [
                'string',
                'nullable'
            ],
            'file_sk_id' => [
                'string',
                'nullable'
            ],
            'ref_jenis_id' => [
                'string',
                'nullable'
            ],
            'validator_id' => [
                'string',
                'nullable'
            ],
            'nama' => [
                'string',
                'required'
            ],
            'nama_eng' => [
                'string',
                'nullable'
            ],
            'tgl_mulai' => [
                'date',
                'before_or_equal:tgl_selesal'
            ],
            'tgl_selesai' => [
                'date',
                'after_or_equal:tgl_mulai'
            ],
            'status_validasi' => [
                'numeric',
                'required'
            ],
            'pesan' => [
                'string',
                'nullable'
            ]
        ];
    }
}
