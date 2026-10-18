<?php

// app/Http/Controllers/DocumentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function show($file)
    {
      
        $path = 'http://localhost/noc_documents/' . $file;
            //dd($path);

        return redirect("$path");
        //dd($path);

        // if (file_exists($file)) {
        //     return $path;
        // }

        // abort(404);
        //return "Hello";
        // return view('layouts\admin\back_attachment',compact('path'));
    }
}
