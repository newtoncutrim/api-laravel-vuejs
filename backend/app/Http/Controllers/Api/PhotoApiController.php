<?php

namespace App\Http\Controllers\Api;

use App\Models\Photo;
use Illuminate\Http\Response;
use App\Services\PhotoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhotoApiController extends Controller
{

    public function __construct( protected PhotoService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 2);
        $page = $request->query('page', 1);

        $user = auth()->user();
        $photos = $this->service->showPhotos($user);

        $totalItems = $photos->count();
        $currentPage = $page;
        $itemsPerPage = $perPage;
        $lastPage = ceil($totalItems / $itemsPerPage);

        $photos = $photos->forPage($currentPage, $itemsPerPage);

        $response = [
            "pagina_atual" => $currentPage,
            "total_paginas" => $lastPage,
            "total_registros" => $totalItems,
            "registros_por_pagina" => $itemsPerPage,
            "registros" => $photos->values()->all(),
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function find(int $id): JsonResponse
    {
        $photo = $this->service->findOne($id);
        return response()->json(['image_path' => $photo, Response::HTTP_OK]);
    }

    public function upload(UploadRequest $request): JsonResponse
    {
        $user = auth()->user();

        $this->service->upload($request, $user->id);

        $lastRecord = Photo::latest()->first();

        if ($lastRecord) {

            $path = $lastRecord->image_path;

            return response()->json(['message' => 'Upload realizado com sucesso', 'image_path' => $path], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Nenhum arquivo enviado.'], Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(Request $request,  $id){

        $this->service->update($request,$id);
        $data = $this->service->findOne($id);
        return response()->json(["message" => "Updated success", "data" => $data], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
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
