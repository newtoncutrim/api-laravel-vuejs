<?php

namespace App\Services;

use App\Repository\PhotoRepository;

class PhotoService {
    public function __construct(protected PhotoRepository $repository)
    {}

    public function showPhotos($user)
    {
        return $this->repository->show($user->id);
    }

    public function upload($request, $userId)
    {
        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('photos');

            $this->repository->upload($path, $userId);
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
