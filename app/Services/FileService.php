<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * @param $file
     * @param $item
     */
    public function uploadFile($file, $item)
    {
        $path = '/';
        $filename = rand(11111, 99999) . '_' . $file->getClientOriginalName();

        $filePath = Storage::disk('files')
            ->putFileAs(
                $path,
                $file,
                $filename);

        File::query()->create([
            'filepath' => $filePath,
            'title' => $file->getClientOriginalName(),
            'fileable_id' => $item->id,
            'fileable_type' => get_class($item)
        ]);
    }

}
