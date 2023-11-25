<?php

namespace App\Repository\Contract;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements InterfaceRepository {
    protected Model $model;

    public function Show($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

    public function new($data){
        return $this->model->create($data);

    }

    public function update($id, $dataToUpdate) {
        $data = $this->model->find($id);

        if (!$data) {
            throw new \Exception("Registro não encontrado");
        }
        $data->update($dataToUpdate);

        return $data->save();
    }

    public function upload($data, $userId, $description)
    {

        return $this->model->create([
            'image_path' => $data,
            'title' => $description,
            'user_id' => $userId
        ]);
    }

    public function destroy(int $id)
    {
        $data = $this->model->find($id);

       return $data->delete();
    }

    public function findOne(int $id)
    {
        $data = $this->model->find($id);

        return $data;
    }
}
