<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HkiRequest extends FormRequest
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
            'siakad_mhspt_id'  => [
                'required',
                'numeric'
            ],
            'jenis_hki_id' => [
                'required',
                'string'
            ],
            'jenis_ciptaan_id' => [
                'required',
                'string'
            ],
            'file' => [
                'mimes:pdf,jpg,png',
                'required_without:file_bukti_id'
            ],
            'file_bukti_id' => [
                'nullable',
                'string'
            ],
            'nomor_sertifikat' => [
                'required',
                'string'
            ],
            'tgl_mulai_berlaku' => [
                'required',
                'date',
                'before_or_equal:tgl_berakhir'
            ],
            'tgl_berakhir' => [
                'required',
                'date',
                'after_or_equal:tgl_mulai_berlaku'
            ],
            'nama_hki' => [
                'string',
                'required'
            ],
            'nama_hki_eng' => [
                'string',
                'nullable'
            ],
            'pemegang_hki' => [
                'string',
                'nullable'
            ],
            'deskripsi_hki' => [
                'string',
                'nullable'
            ],
            'status_validasi' => [
                'numeric',
                'required'
            ]
        ];
    }
}
