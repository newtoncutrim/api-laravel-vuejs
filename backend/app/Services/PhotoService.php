<?php

namespace App\Services;

use App\Repository\PhotoRepository;

class PhotoService {
    public function __construct(protected PhotoRepository $repository)
    {}

    public function showPhotos()
    {
        return $this->repository->show();
    }

    public function upload($request)
    {
        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('photos');

            $this->repository->upload($path);
        }
    }
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    public function delete(int $id)
    {
        return $this->repository->destroy($id);
    }
}
