<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KBAsingRequest extends FormRequest
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
            'ref_bahasa_id' => [
                'required',
                'string'
            ],
            'ref_level_bahasa_id' => [
                'required',
                'string'
            ],
            'ref_jenis_tes_id' => [
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
            'validator_id' => [
                'string',
                'nullable'
            ],
            'nilai_tes' => [
                'numeric'
            ],
            'status_validasi' => [
                'numeric'
            ],
            'pesan' => [
                'string',
                'nullable'
            ],
            'tgl_mulai' => [
                'date',
                'before_or_equal:tgl_selesai'
            ],
            'tgl_selesai' => [
                'date',
                'after_or_equal:tgl_mulai'
            ]
        ];
    }
}
