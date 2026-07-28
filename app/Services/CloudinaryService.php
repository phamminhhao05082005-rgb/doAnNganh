<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public function uploadFile($file, string $folder = 'uploads'): array
    {
        $uploaded = Cloudinary::uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => $folder
            ]
        );

        return [
            'url' => $uploaded['secure_url'],
            'public_id' => $uploaded['public_id'],
        ];
    }

    public function uploadUrl(string $url, string $folder = 'uploads'): array
    {
        $uploaded = Cloudinary::uploadApi()->upload(
            $url,
            [
                'folder' => $folder
            ]
        );

        return [
            'url' => $uploaded['secure_url'],
            'public_id' => $uploaded['public_id'],
        ];
    }

    public function destroy(?string $publicId): void
    {
        if (!$publicId) {
            return;
        }

        Cloudinary::uploadApi()->destroy($publicId);
    }
}