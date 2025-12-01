<?php

namespace App\Repositories;

use App\Models\Media;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Media::class;
    }

    /**
     *
     * @param UploadedFile $file The file to store.
     * @param string $path The path to store the file.
     * @param string|null $type The type of media to store. If null, the type will be automatically determined.
     * @return Media The stored media.
    
     */



    public static function storeByRequest(UploadedFile $file, string $path, ?string $type = null): Media
    {

        $path = Storage::disk("public")->put("/" . trim($path, "/"), $file);
        $extension = $file->extension();

        if (!$type) {
            $type = in_array($extension, ["jpeg", "jpg", "png", "webp", "gif", "svg"]) ? "image" : $extension;
        }

        $media = self::create([
            "type" => $type,
            "src" => $path,
            "name" => $file->getClientOriginalName(),
            "extension" => $extension,
        ]);

        return $media;
    }
}
