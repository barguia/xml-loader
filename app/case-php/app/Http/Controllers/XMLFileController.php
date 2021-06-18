<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\XMLFileRequest;
use App\Models\XMLFile;
use App\Http\Resources\XMLFileCollection;

class XMLFileController extends Controller
{

    public function upload(XMLFileRequest $request, XMLFile $xmlFile)
    {
        return new XMLFileCollection([$xmlFile->storeFile($request)]);
    }
}
