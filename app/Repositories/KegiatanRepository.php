<?php

namespace App\Repositories;

use App\Models\Kegiatan;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\CrudInterface;
use App\Traits\RelasiTrait;

class KegiatanRepository implements CrudInterface
{
    use RelasiTrait;
    public function findAll($options = [])
    {
        $mhspt = $options['mhspt'] ?? null;
        $jenis = $options['jenis'] ?? null;
        $data = Kegiatan::when($mhspt, function ($q, $mhspt) {
            $q->where('siakad_mhspt_id', $mhspt);
        })->when($jenis, function ($q, $jenis) {
            $q->where('ref_jenis_kegiatan_id', $jenis);
        });

        return $data->get();
    }

    public function findById($id)
    {
        return Kegiatan::findOrFail($id);
    }

    public  function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $relasi = $this->relasiData($params['ref_jenis_kegiatan_id'])['model'];
            $createRelasi = $relasi->create($params);
            $kegiatan_id = [
                'kegiatan_id' => $createRelasi->{$this->relasiData($params['ref_jenis_kegiatan_id'])['model']->getKeyName()}
            ];
            $params = array_merge($params, $kegiatan_id);
            return Kegiatan::create($params);
        });
    }

    public function update($id, $params = [])
    {
        $data = $this->findById($id);
        return DB::transaction(function () use ($params, $data) {
            $data->update($params);
            return $data->relasi->fill($params)->save();
        });
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        $data->relasi()->delete();
        return $data->delete();
    }
}
