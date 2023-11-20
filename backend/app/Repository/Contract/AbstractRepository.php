<?php

namespace App\Repository\Contract;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements InterfaceRepository {
    protected Model $model;

    public function Show(){
        return $this->model->all();
    }

    public function upload($data){
        return $this->model->create(['image_path' => $data]);
    }

    public function destroy($id){
        $data = $this->model->find($id);

       return $data->delete();

    }

    public function findOne($id){
        $data = $this->model->find($id);

        return $data;
    }
}
