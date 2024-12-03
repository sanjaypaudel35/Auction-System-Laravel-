<?php

namespace App\Core\Traits;

use App\Enums\ImageTypeEnums;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{
    protected string $storageDriver = "public";

    public function imageUpload(mixed $image, string $folderName): string
    {
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileName = $filename.'_'.time().'.'.$extension;

        $imageFolder = ImageTypeEnums::IMAGE_FOLDER->value;
        $directoryPath = "{$imageFolder}/{$folderName}";
        $path = $image->storeAs($directoryPath, $fileName, $this->storageDriver);
        session()->put("filepath", $path);

        return $path;
    }

    public function deleteImage(string $path): void
    {
        if ($path) {
            Storage::disk($this->storageDriver)->delete($path);
        }
    }
}
