<?php

namespace App\Http\Services\Image;

use Illuminate\Support\Facades\Config;
use Intervention\Image\Image;
use Intervention\Image\ImageCache;
use Intervention\Image\Facades\Image as ImageService;
use Intervention\Image\ImageManager;

class ImageCacheService
{

    public function cache($imagePath, $size = '')
    {
        // set image size
        $imageSizes = Config::get('image.cache-image-sizes');
        if (!isset($imageSizes[$size])) {
            $size = Config::get('image.default-current-cache-image');
        }
        $width = $imageSizes[$size]['width'];
        $height = $imageSizes[$size]['height'];

        // cache image
        if (file_exists($imagePath)) {
            $img = ImageService::cache(function ($image) use ($imagePath, $width, $height) {
                return $image->make($imagePath)->fit($width, $height);
            }, Config::get('image.image-cache-life-time'), true);
        } else {
            $img = \Intervention\Image\Facades\Image::canvas($width, $height, '#cdcdcd')
                ->text('Not-Found-404', $width / 2, $height / 2, function ($font) {
                    $font->color('#333333');
                    $font->align('center');
                    $font->valign('center');
                    $font->file(public_path('admin-assets/fonts/vazir/Vazir.woff'));
                    $font->size(24);
                });
        }
        return $img->response();
    }

}
