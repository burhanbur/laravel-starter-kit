<?php

namespace App\Utilities;

use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Document
{
    protected string $disk;

    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk;
    }

    public function saveDocs(UploadedFile $file, string $title, ?string $folder = null, $id = null): string
    {
        $suffix = $id ? '-'.$id : '';
        $fileName = Str::slug($title).'-'.date('YmdHis').$suffix.'.'.$file->getClientOriginalExtension();
        $path = $folder ? ($folder.'/'.$fileName) : $fileName;

        if (! Storage::disk($this->disk)->putFileAs($folder ?? '', $file, $fileName)) {
            throw new \RuntimeException('Failed to store file.');
        }

        return $fileName;
    }

    public function deleteDocs(string $filename, ?string $folder = null): bool
    {
        $path = $folder ? ($folder.'/'.$filename) : $filename;
        return Storage::disk($this->disk)->exists($path) ? Storage::disk($this->disk)->delete($path) : false;
    }
}
