<?php

namespace App\Repositories;

use App\Models\Kewirausahaan;
use App\Repositories\Interfaces\CrudInterface;

class KewirausahaanRepository implements CrudInterface
{
    public function findAll($options = [])
    {
        $mhspt = $options['mhspt'] ?? null;
        $data = Kewirausahaan::when($mhspt,function($query,$mhspt){
            $query->where('siakad_mhspt_id',$mhspt);
        });
        return $data->get();
    }

    public function findById($id)
    {
        return Kewirausahaan::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params){
            $data_update = Kewirausahaan::create($params);
            return $data_update;
        });
    }

    public function update($id, $params = [])
    {
        $data = $this->findById($id);
        return DB::transaction(function () use ($params,$data){
            return $data->update($params);
        });
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        return $data->delete();
    }
}
