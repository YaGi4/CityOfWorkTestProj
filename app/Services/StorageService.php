<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StorageService
{

    public function saveCoverFile(UploadedFile $uploadedFile): string
    {
        return Storage::disk('public')->put('books/covers', $uploadedFile);
    }

    public function deleteCoverFile(string $oldPath): void
    {
        Storage::disk('public')->delete($oldPath);
    }

}
