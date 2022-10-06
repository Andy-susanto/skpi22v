<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $table        = 'file_kegiatan';
    protected $fillable      = [
        'id_files',
        'nama',
        'path',
        'tag',
        'ref_jenis_kegiatan_id',
        'siakadd_mhspt_id'
    ];
    protected $primaryKey   = 'id_files';
    public    $incrementing = true;
}
