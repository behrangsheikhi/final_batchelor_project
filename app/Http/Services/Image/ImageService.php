<?php

namespace App\Http\Services\Image;

use App\Http\Services\Image\ImageToolsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class ImageService extends ImageToolsService
{
    public function save($image): bool|string
    {
        // set image
        $this->setImage($image);

        // execute provider
        $this->provider();

        // save image to public
        $result = Image::make($image->getRealPath())->save(public_path($this->getImageAddress()), 85, $this->getImageFormat());

        return $result ? $this->getImageAddress() : false;
    }

    public function fitAndSave($image, $width, $height): bool|string
    {
        // set image
        $this->setImage($image);

        // execute provider
        $this->provider();

        // save image to public
        $result = Image::make($image->getRealPath())->fit($width, $height)->save(public_path($this->getImageAddress()), 85,
            $this->getImageFormat());

        return $result ? $this->getImageAddress() : false;
    }


    public function createGalleryImages($image)
    {
        // get data from config
        $imageSizes = Config::get('image.index-image-sizes');

        // set image
        $this->setImage($image);

        // generate directory structure based on current date and time
        $currentDateTime = Carbon::now();
        $year = $currentDateTime->format('Y');
        $month = $currentDateTime->format('m');
        $day = $currentDateTime->format('d');
        $time = $currentDateTime->format('His');

        // set main image directory
        $mainImageDirectory = $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day;
        $this->setImageDirectory($mainImageDirectory);

        // create the main image directory if it doesn't exist
        $this->checkDirectory(public_path($mainImageDirectory));

        $indexArray = [];
        foreach ($imageSizes as $sizeAlias => $imageSize) {
            // create subfolder for each image size
            $currentImageDirectory = $mainImageDirectory . DIRECTORY_SEPARATOR . $time . DIRECTORY_SEPARATOR . $sizeAlias;
            // set image directory
            $this->setImageDirectory($currentImageDirectory);

            // generate image name
            $imageName = $this->getImageName() . '.jpg';

            // execute current image name
            $this->provider();

            // save image
            $result = Image::make($image->getRealPath())->fit($imageSize['width'], $imageSize['height'])->save(public_path($this->getImageAddress()), 85, 'jpg');

            if ($result) {
                $indexArray[$sizeAlias] = $this->getImageAddress();
            } else {
                return false;
            }
        }

        $image->indexArray = $indexArray;
        $image->directory = $this->getFinalImageDirectory();
        $image->currentImage = Config::get('image.default-current-index-image');

        return $image;
    }

    public function createIndexAndSave($image)
    {
        // get data from config
        $imageSizes = Config::get('image.index-image-sizes');

        // set image
        $this->setImage($image);

        // set directory only once for all images
            $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
        $this->setImageDirectory($this->getImageDirectory() . DIRECTORY_SEPARATOR . time());

        // set image name
            $this->getImageName() ?? $this->setImageName(time());
        $imageName = $this->getImageName();

        // Directory is set, now loop through image sizes
        $indexArray = [];
        foreach ($imageSizes as $sizeAlias => $imageSize) {
            $currentImageName = $imageName . '_' . $sizeAlias;
            $this->setImageName($currentImageName);

            // execute current image name
            $this->provider();

            // save image
            $result = Image::make($image->getRealPath())->fit($imageSize['width'], $imageSize['height'])->save(public_path($this->getImageAddress()), 85, $this->getImageFormat());

            if ($result) {
                $indexArray[$sizeAlias] = $this->getImageAddress();
            } else {
                return false;
            }
        }

        $image->indexArray = $indexArray;
        $image->directory = $this->getFinalImageDirectory();
        $image->currentImage = Config::get('image.default-current-index-image');

        return $image;
    }

    public function deleteImage($image): void
    {
        if (file_exists($image)) {
            unlink($image);
        }
    }

    public function deleteDirectoryAndFiles($directory): bool
    {
        if (!is_dir($directory)) {
            return false;
        }
        $files = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDirectoryAndFiles($file);
            } else {
                unlink($file);
            }
        }
        return rmdir($directory);
    }

    public function deleteIndex($images): void
    {
        $directory = public_path($images['directory']);
        $this->deleteDirectoryAndFiles($directory);
    }


}

