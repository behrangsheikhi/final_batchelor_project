<?php

namespace App\Http\Services\Image;

use Doctrine\Inflector\Rules\English\Inflectible;
use http\Encoding\Stream\Inflate;
use http\Exception\UnexpectedValueException;
use Illuminate\Support\Facades\Config;

class ImageToolsService
{
    protected $image;
    protected $exclusiveDirectory;
    protected $imageDirectory;
    protected $imageName;
    protected $imageFormat;
    protected $finalImageDirectory;
    protected $finalImageName;

    // getters
    public function setImage($value): void
    {
        $this->image = $value;
    }

    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }

    public function setExclusiveDirectory($value): void
    {
        $this->exclusiveDirectory = trim($value, '/\\');
    }

    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    public function setImageDirectory($value): void
    {
        $this->imageDirectory = trim($value, '/\\');
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageName($value): void
    {
        $this->imageName = $value;
    }

    public function setCurrentImageName(): ?bool
    {
        return !empty($this->image) ? $this->setImageName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME)) : false;
    }

    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    public function setImageFormat($value)
    {
        $this->imageFormat = $value;
    }

    public function getFinalImageDirectory()
    {
        return $this->finalImageDirectory;
    }

    public function setFinalImageDirectory($value): void
    {
        $this->finalImageDirectory = $value;
    }

    public function getFinalImageName()
    {
        return $this->finalImageName;
    }

    public function setFinalImageName($value): void
    {
        $this->finalImageName = $value;
    }

    public function checkDirectory($imageDirectory)
    {
//        dd($this->imageDirectory);
        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 777, true);
        }
    }

    public function getImageAddress()
    {
        return $this->finalImageDirectory . DIRECTORY_SEPARATOR . $this->finalImageName;
    }

    // use this method to upload image
    public function provider(): void
    {
        // set properties
            $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m')
            . DIRECTORY_SEPARATOR . date('d'));
            $this->getImageName() ?? $this->setImageName(time());
            $this->getImageFormat() ?? $this->setImageFormat($this->image->extension());

        // set final image directory
        $finalImageDirectory = empty($this->getExclusiveDirectory()) ? $this->getImageDirectory() :
            $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getImageDirectory();
        $this->setFinalImageDirectory($finalImageDirectory);

        // set final image name
        $this->setFinalImageName($this->getImageName() . '.' . $this->getImageFormat());

        // check and create final image directory
        $this->checkDirectory($this->getFinalImageDirectory());

    }

}

