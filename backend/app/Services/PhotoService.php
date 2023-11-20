<?php

namespace App\Services;

use App\Models\Photo;
use App\Repository\PhotoRepository;
use Illuminate\Http\Response;

class PhotoService {
    public function __construct(protected PhotoRepository $repository)
    {}

    public function showPhotos(){
        return $this->repository->show();
    }

    public function upload($request){
        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('photos');
            /* dd($path); */

            $this->repository->upload($path);
        }
    }
    public function findOne($id){
        return $this->repository->findOne($id);
    }

    public function delete($id){
        return $this->repository->destroy($id);
    }
}
