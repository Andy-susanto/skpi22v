<?php
namespace App\Repositories;
use DB;
use App\Models\Publikasi;
use App\Repositories\Interfaces\CrudInterface;

class PublikasiRepository implements CrudInterface{
    public function findAll($options = [])
    {
        $mhspt = $options['siakad_mhspt_id'] ?? null;
        $data = Publikasi::when($mhspt,function($query,$mhspt){
            $query->where('siakad_mhspt_id',$mhspt);
        });
        return $data->get();
    }

    public function findById($id)
    {
        return Publikasi::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            if($data = Publikasi::create($params)){
                return $data;
            }
        });
    }

    public function update($id, $params = [])
    {
        $data = $this->findById($id);
        return DB::transaction(function () use ($params) {
            return $data->update($params);
        });
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        return $data->delete();
    }
}
