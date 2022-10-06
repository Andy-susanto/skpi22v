<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KewirausahaanRequest extends FormRequest
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
                'string',
            ],
            'ref_kategori_id' => [
                'required',
                'string'
            ],
            'validator_id' => [
                'numeric'
            ],
            'file' => [
                'required_without:file_kegiatan_id',
                'mimes:pdf,docs',
                'max:5000'
            ],
            'file_kegiatan_id' => [
                'numeric'
            ],
            'file_kegiatan_ref_jenis_kegiatan_id' => [
                'numeric'
            ],
            'nama_usaha' => [
                'required',
                'string'
            ],
            'nama_usaha_eng' => [
                'string',
                'nullable'
            ],
            'alamat_usaha' => [
                'required',
                'string'
            ],
            'no_izin' => [
                'string',
                'nullable'
            ],
            'status_validasi' => [
                'numeric'
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
