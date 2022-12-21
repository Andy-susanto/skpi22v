<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarRequest extends FormRequest
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
            'nama_eng' => [
                'string'
            ],
            'file_id' => [
                'required_without:file_kegiatan_id',
                'mimes:pdf,docs',
                'max:5000'
            ],
            'file_sk_id' => [
                'required_without:file_kegiatan_id',
                'mimes:pdf,docs',
                'max:5000'
            ],
            'kepeg_pegawai_id' => [
                'nullable',
                'string'
            ],
            'ref_tingkat_id' => [
                'required',
                'string'
            ],
            'ref_peran_prestasi_id' => [
                'required',
                'string'
            ],
            'ref_penyelenggara_id' => [
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
