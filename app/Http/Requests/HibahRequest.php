<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HibahRequest extends FormRequest
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
            'siakad_mhspt_id' => [
                'required',
                'string'
            ],
            'kepeg_pegawai_id' => [
                'nullable',
                'string'
            ],
            'ref_penyelenggara_id' => [
                'required',
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
            'ref_peran_prestasi_id' => [
                'nullable',
                'string'
            ],
            'file_id' => [
                'nullable',
                'string'
            ],
            'file_sk_id' => [
                'nullable',
                'string'
            ],
            'tgl_mulai' => [
                'date',
                'string'
            ],
            'tgl_selesai' => [
                'date',
                'string'
            ],
        ];
    }
}
