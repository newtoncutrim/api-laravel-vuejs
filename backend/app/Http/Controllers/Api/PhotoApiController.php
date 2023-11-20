<?php

namespace App\Http\Controllers\Api;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\PhotoService;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;

class PhotoApiController extends Controller
{

    public function __construct( protected PhotoService $service)
    {
        $this->service = $service;
    }

    public function show(){
        $photos = $this->service->showPhotos();
        return response()->json(['data' => $photos], Response::HTTP_OK);
    }

    public function find($id){
        $photo = $this->service->findOne($id);
        return response()->json(['image_path' => $photo, Response::HTTP_OK]);
    }

    public function upload(UploadRequest $request)
    {
        /* dd($request->all()); */
        $this->service->upload($request);

        $lastRecord = Photo::latest()->first();

        if ($lastRecord) {

            $path = $lastRecord->image_path;

            return response()->json(['message' => 'Upload realizado com sucesso', 'image_path' => $path], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Nenhum arquivo enviado.'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $data = $this->service->findOne($id);

        if($data){
            $this->service->delete($id);
            return response()->json(['message' => 'Registro deletado com sucesso', 'image_path' => $data], Response::HTTP_OK);
        } else {
            return response()->json(['error' => "Registro não encontrado", Response::HTTP_NOT_FOUND]);
        }


    }

}
