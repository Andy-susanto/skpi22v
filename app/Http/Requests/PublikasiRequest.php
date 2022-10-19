<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublikasiRequest extends FormRequest
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
                'string',
                'nullable'
            ],
            'kategori_capaian_id' => [
                'string',
                'required'
            ],
            'jenis_id' => [
                'string',
                'required'
            ],
            'file' => [
                'mimes:pdf,jpg,png',
                'max:5000',
                'required_without:file_bukti_id'
            ],
            'file_bukti_id' => [
                'string',
                'nullable'
            ],
            'judul' => [
                'string',
                'required'
            ],
            'tgl_terbit' => [
                'date',
                'required'
            ],
            'penerbit' => [
                'string',
                'required'
            ],
            'tautan_eksternal' => [
                'string',
                'nullable'
            ]
        ];
    }
}
