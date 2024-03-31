<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Requests\UploadMediaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadMediaRequest $request, Media $media): JsonResponse
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // اعتبارسنجی فایل (در صورت نیاز)
            $file_name = $file->hashName();
            
            $disk = Storage::disk('public'); // یا هر دیسک قابل تنظیم دیگری
            
            $file_path = 'storage/uploads/' . $file_name;
            Storage::disk('public')->putFileAs('uploads', $file, $file_name);

            $file_hash = hash_file('sha256', $file_path);

            $media = Media::create(
                [
                    'name' => $file->getClientOriginalName(),
                    'file_name' => $file_name,
                    'type' => 'image', // یا تعیین نوع فایل به صورت پویا
                    'mime_type' => $file->getClientMimeType(),
                    'path' => $file_path,
                    'file_hash' => $file_hash,
                    'disk' => 'public',
                    'size' => $file->getSize()
                ]
            );

            return response()->json(['status'=>'success','file_id' => $media->id]); // بازگشت هش به عنوان پاسخ موفق
        }

        return response()->json(['status'=> 'error','error' => 'No file uploaded'], 400);
        // dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}
