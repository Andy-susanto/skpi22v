<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiakadUser extends Model
{
    use HasFactory;
    protected $table   = 'siakad.users';
    protected $guarded = [];

    public function siakad_file(){
        return $this->hasOne(SiakadFiles::class,'user','id')->where('jenis','like',"%Photo Profil");
    }

    public function mhspt(){
        return $this->hasOne(SiakadMhspt::class,'no_mhs','username');
    }

}
