<?php
namespace App\Repositories;
use DB;
use App\Models\Hki;
use App\Repositories\Interfaces\CrudInterface;

class HkiRepository implements CrudInterface{
    public function findAll($options = [])
    {
        $mhspt = $options['siakad_mhspt_id'] ?? null;
        $data = Hki::when($mhspt,function($query,$mhspt){
            $query->where('siakad_mhspt_id',$mhspt);
        });
        return $data->get();
    }

    public function findById($id)
    {
        return Hki::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            if($data = Hki::create($params)){
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
