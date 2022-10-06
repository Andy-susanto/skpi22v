<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeasiswaRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => [
                'required',
                'string'
            ],
            'nama_promotor' => [
                'required',
                'string'
            ],
            'nama_eng' => [
                'string'
            ],
            'file' => [
                'required_without:file_kegiatan_id',
                'mimes:pdf,docs',
                'max:5000'
            ],
            'ref_kategori_id' => [
                'required',
                'numeric'
            ],
            'ref_cakupan_beasiswa_id' => [
                'required',
                'numeric'
            ],
            'file_kegiatan_id' => [
                'numeric'
            ],
            'file_kegiatan_ref_jenis_kegiatan_id' => [
                'numeric'
            ],
            'status_validasi' => [
                'numeric'
            ],
            'pesan' => [
                'string'
            ],
            'validator_id' => [
                'numeric'
            ],
            'tgl_mulai' => [
                'date',
                'before_or_equal:tgl_selesal'
            ],
            'tgl_selesai' => [
                'date',
                'after_or_equal:tgl_mulai'
            ]
        ];
    }

    public function messages()
    {
        return [
            'file.required_without' => 'Anda Belum mengupload dokumen'
        ];
    }
}
