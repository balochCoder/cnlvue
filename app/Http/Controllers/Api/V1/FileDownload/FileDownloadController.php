<?php

namespace App\Http\Controllers\Api\V1\FileDownload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($filePath)
    {
        $filePath = urldecode($filePath);
        // Convert the public file path to a relative path in the storage directory
        $filePath = str_replace(['http://localhost:8000/storage/', 'storage/'], '', $filePath);

        // Check if the file exists
        if (!Storage::exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Stream the file for download
        return Storage::download($filePath);
    }
}
