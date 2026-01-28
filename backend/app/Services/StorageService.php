<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageService
{
    protected $disk = 's3';

    public function uploadImage(string $content, string $folder = 'generated'): string
    {
        $filename = $folder . '/' . Str::random(40) . '.jpg';
        Storage::disk($this->disk)->put($filename, $content, 'public');
        return $filename;
    }

    public function getUrl(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }
    
    public function getPresignedUrl(string $path, int $minutes = 60): string
    {
        return Storage::disk($this->disk)->temporaryUrl($path, now()->addMinutes($minutes));
    }
}
