<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Photo;
use Illuminate\Http\Request;

class TesteUpload extends Controller
{
    public function testeUpload(){
        $photos = Photo::all();

        return view('exibir', ['photos' => $photos]);
    }
    public function up(){
        return view('teste');
    }

    public function testeUpload_action(Request $request){

        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photos');

            Photo::create(['image_path' => $path]);

            return redirect()->route('teste.exibir');
        } else {
            return 'Nenhum arquivo enviado.';
        }
    }

}
