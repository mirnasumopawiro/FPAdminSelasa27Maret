<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $extension = $request->file('uploaded_file')->extension();
        $path = Storage::putFileAs('uploads',$request->file('uploaded_file'),time().'.'.$extension);

        return back()->with('success_message','Upload successful');
    }
}
