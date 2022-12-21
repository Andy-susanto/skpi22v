<?php

namespace App\Repositories;

use DB;
use App\Models\Files;
use App\Models\JenisKegiatan;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Storage;

class FileRepository implements CrudInterface
{
    public function findAll($options = [])
    {
    }

    public function findById($id)
    {
        return Files::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $file = $params['file'] ?? null;
            if (!$file) {
                return true;
            }

            $jenisKegiatan = JenisKegiatan::where('id_ref_jenis_kegiatan', $params['jenis_kegiatan'])->first();

            $name = time() . '_' . $jenisKegiatan->nama . '_' . Auth::user()->username . '.' . $params['file']->getclientOriginalExtension();
            $path = $file->storeAs('uploads', $name, 'public');
            $fileParams = [
                'nama' => $name,
                'path' => $path,
                'tag' => $jenisKegiatan->nama,
                'ref_jenis_kegiatan_id' => $params['jenis_kegiatan'],
                'siakad_mhspt_id' => $params['id_mhspt']
            ];

            $newParams = array_merge($params, $fileParams);
            $data =  Files::create($newParams);
            return $data;
        });
    }

    public function update($id, $params = [])
    {
        $data = $this->findById($id);
        return DB::transaction(function () use ($params, $data) {
            if (Storage::exists($data->path)) {
                Storage::delete($data->path);
                $file = $params['file'];
                if (empty($file)) {
                    return true;
                }
                $name = time() . '_' . $jenisKegiatan->nama . '_' . Auth::user()->username . '.' . $params['file']->getclientOriginalExtension();
                $path = $file->storeAs('uploads', $name, 'public');
                $fileParams = [
                    'nama' => $name,
                    'path' => $path,
                    'id_files' => $data->id_files
                ];
                $newParams = array_merge($params, $fileParams);
                return Files::update($newParams);
            }

            return $data;
        });
    }

    public function delete($id)
    {
        $data = Files::findOrFail($id);
        return DB::transaction(function () use ($data, $id) {
            if (Storage::exists($data->path)) {
                Storage::delete($data->path);
                return $data->delete();
            }

            return $data;
        });
    }
}
