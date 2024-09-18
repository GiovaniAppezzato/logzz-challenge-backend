<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class StoreBase64File extends Action
{
    public function __construct(
        protected $base64File,
    ) {}

    public function handle(): string
    {
        // Decode the base64 file
        $fileContent = $this->processBase64File($this->base64File);

        // Generate a unique file name
        $fileName = md5(time()) . '.' . explode('/', $this->getMimeType())[1];

        // Store the file
        return $this->storeFile($fileContent, $fileName);
    }

    private function processBase64File($base64File)
    {
        $parts = explode(';', $base64File);
        $data = explode(',', $parts[1])[1];

        return base64_decode($data);
    }

    private function storeFile($fileContent, $fileName)
    {
        Storage::disk('public')->put('products/' . $fileName, $fileContent);

        return url(Storage::url('products/' . $fileName));
    }

    private function getMimeType()
    {
        return explode(';', explode(':', $this->base64File)[1])[0];
    }
}
