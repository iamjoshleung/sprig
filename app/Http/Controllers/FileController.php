<?php

namespace App\Http\Controllers;

use App\File;
use App\Movie;
use App\DownloadToken;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFile;

class FileController extends Controller
{
    public function store(StoreFile $request) {
        $currentDate = now()->toDateString();
        $file = $request->file('file');

        $fileModel = new File;

        $fileModel->name = $file->getClientOriginalName();
        $fileModel->size = $file->getClientSize();
        $fileModel->mime = $file->getClientMimeType();
        $fileModel->delete_token = str_random(20);
        $fileModel->path = $file->store("uploads/{$currentDate}");

        $fileModel->save();


        return response()->json([
            'path' => $fileModel->path,
            'link' => $fileModel->link,
            'id' => $fileModel->getRouteKey(),
            'deleteToken' => $fileModel->delete_token,
        ], 201);
    }

    /**
     * 
     * 
     * @return 
     */
    public function show(File $file) {
        $topMovies = Movie::getTopMovies();
        return view('download', ['file' => $file, 'topMovies' => $topMovies]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function destroy(File $file, string $token) {
        if( $file->delete_token !== $token ) {
            return response([], 401);
        }
        $file->delete();
        \Storage::delete($file->path);
        return response([], 204);
    }

    /**
     * 
     * 
     * @return 
     */
    public function generateToken(File $file) {
        $token = $file->tokens()->create([
            'token' => str_random(20),
            'expired_at' => now()->addMinutes(30)
        ]);

        return response($token, 201);
    }

    /**
     * 
     * 
     * @return 
     */
    public function download(File $file, DownloadToken $downloadToken) {
        // return response()->json($downloadToken->expired_at);
        if( now()->lte($downloadToken->expired_at) ) {
            $file->increment('downloads');
            return \Storage::download($file->path);
        } else {
            return response()->json('token expired', 403);
        }
    }
}
