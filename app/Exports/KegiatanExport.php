<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KegiatanExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $collection;
    public function __construct($data){
       $this->collection = $data;
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings():array
    {
        return ['Nama Mahasiswa','NIM','Prodi','Jenis Kegiatan','Nama Kegiatan'];
    }
}
