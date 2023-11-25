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
        $title = $request->title;
        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('photos');

            $this->repository->upload($path, $userId, $title);
        }
    }

    public function update($request, $id){
        $photo = $this->findOne($id);
        if(!$photo){
            throw new \Exception("Arquivo não inexistente");
        }
        $dataToUpdate = [
            'title' => $request->input('title'),
            'image_path' => $request->file('image_path')->store('photos'),
            // Outros campos a serem atualizados conforme necessário
        ];
        return $this->repository->update($id, $dataToUpdate);
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
