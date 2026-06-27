<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\UploadFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function indexForProject(Request $request, $project): JsonResponse
    {
        $files = File::where('fileable_type', 'App\\Models\\Project')
                     ->where('fileable_id', $project)
                     ->with('uploader')->latest()->get();

        return response()->json(FileResource::collection($files));
    }

    public function indexForTask(Request $request, $task): JsonResponse
    {
        $files = File::where('fileable_type', 'App\\Models\\Task')
                     ->where('fileable_id', $task)
                     ->with('uploader')->latest()->get();

        return response()->json(FileResource::collection($files));
    }

    public function uploadToProject(UploadFileRequest $request, $project): JsonResponse
    {
        $uploaded = $this->storeFiles($request, 'App\\Models\\Project', (int) $project);
        return response()->json(FileResource::collection($uploaded), 201);
    }

    public function uploadToTask(UploadFileRequest $request, $task): JsonResponse
    {
        $uploaded = $this->storeFiles($request, 'App\\Models\\Task', (int) $task);
        return response()->json(FileResource::collection($uploaded), 201);
    }

    public function show(Request $request, File $file): JsonResponse
    {
        $this->authorize('view', $file);
        $file->load('uploader');
        return response()->json(new FileResource($file));
    }

    public function download(Request $request, File $file): StreamedResponse
    {
        $this->authorize('view', $file);
        abort_unless(Storage::exists($file->path), 404, 'File not found.');
        return Storage::download($file->path, $file->name);
    }

    public function destroy(Request $request, File $file): JsonResponse
    {
        $this->authorize('delete', $file);
        if (Storage::exists($file->path)) Storage::delete($file->path);
        $file->delete();
        return response()->json(['message' => 'File deleted successfully.']);
    }

    private function storeFiles(UploadFileRequest $request, string $fileableType, int $fileableId)
    {
        $created = collect();

        foreach ($request->file('files') as $uploadedFile) {
            $diskName = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();
            $folder   = $fileableType === 'App\\Models\\Project' ? 'project-files' : 'task-files';
            $path     = $uploadedFile->storeAs($folder, $diskName, 'public');

            $file = File::create([
                'name'          => $uploadedFile->getClientOriginalName(),
                'disk_name'     => $diskName,
                'mime_type'     => $uploadedFile->getMimeType(),
                'size'          => $uploadedFile->getSize(),
                'path'          => $path,
                'fileable_type' => $fileableType,
                'fileable_id'   => $fileableId,
                'uploaded_by'   => $request->user()->id,
            ]);

            $file->load('uploader');
            $created->push($file);
        }

        return $created;
    }
}