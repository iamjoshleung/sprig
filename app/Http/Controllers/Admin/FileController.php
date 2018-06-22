<?php

namespace App\Http\Controllers\Admin;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * 
     * 
     * @return 
     */
    public function index(Request $request)
    {
        $itemsPerPage = 20;
        $paginator = File::orderBy('created_at', 'desc')->paginate($itemsPerPage);
        $files = $paginator->items();
        $paginator->data = collect($files)->each->makeVisible('downloads');
        return response()->json(
            $paginator
        );
    }
}