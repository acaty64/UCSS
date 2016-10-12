<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UploadsController extends Controller
{
    public function getIndex()
    {
        return view("admin.import.uploads");
    }

    public function postSave()
    {
        if(!\Input::file("file"))
        {
            return redirect('admin.import.uploads')->with('error-message', 'File has required field');
        }
     
        $mime = \Input::file('file')->getMimeType();
        $extension = strtolower(\Input::file('file')->getClientOriginalExtension());
        $fileName = uniqid().'.'.$extension;
        $path = "imports";
     
        switch ($mime)
        {
            case "application/excel";
    dd('archivo excel');
            case "image/jpeg":
            case "image/png":
            case "image/gif":
            case "application/pdf":
                if (\Request::file('file')->isValid())
                {
                    \Request::file('file')->move($path, $fileName);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    if($upload->save())
                    {
                        return redirect('admin.import.uploads')->with('success-message', 'File has been uploaded');
                    }
                    else
                    {
                        \File::delete($path."/".$fileName);
                        return redirect('admin.import.uploads')->with('error-message', 'An error ocurred saving data into database');
                    }
                }
            break;
            default:
                return redirect('admin.import.uploads')->with('error-message', 'Extension file is not valid');
        }
    }
}
