<?php

namespace App\Http\Controllers;

use App\File;

class DownloadCenterController extends Controller
{
    public function show(File $file)
    {
        return view('download-center', compact('file'));
    }
}
