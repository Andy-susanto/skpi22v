<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiakadFiles extends Model
{
    use HasFactory;
    protected $table      = 'siakad.files';
    protected $primaryKey = 'id_files';
    protected $fillable    = [
        'nama',
        'path',
        'ref_jenis_kegiatan_id',
        'siakad_mhspt_id'
    ];
}
