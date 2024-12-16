<?php

namespace App\Http\Services\File;

use Doctrine\Inflector\Rules\English\Inflectible;

class FileToolsService
{
    protected $file;
    protected $exclusiveDirectory;
    protected $fileDirectory;

    protected $fileName;
    protected $fileFormat;
    protected $finalFileDirectory;
    protected $finalFileName;
    protected $fileSize;

    // getters
    public function setFile($value)
    {
        $this->file = $value;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }
    public function setFileSize($file)
    {
        $this->fileSize = $file->getSize();
    }

    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }

    public function setExclusiveDirectory($value)
    {
        $this->exclusiveDirectory = trim($value, '/\\');
    }


    public function setFileDirectory($value)
    {
        $this->fileDirectory = trim($value, '/\\');
    }

    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }


    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($value)
    {
        $this->fileName = $value;
    }

    public function setCurrentFileName()
    {
        return !empty($this->File) ? $this->setFileName(pathinfo($this->File->getClientOriginalName(), PATHINFO_FILENAME)) : false;
    }

    public function getFileFormat()
    {
        return $this->fileFormat;
    }

    public function setFileFormat($value)
    {
        $this->fileFormat = $value;
    }

    public function getFinalFileDirectory()
    {
        return $this->finalFileDirectory;
    }

    public function setFinalFileDirectory($value)
    {
        $this->finalFileDirectory = $value;
    }

    public function getFinalFileName()
    {
        return $this->finalFileName;
    }

    public function setFinalFileName($value)
    {
        $this->finalFileName = $value;
    }

    public function checkDirectory($fileDirectory)
    {
        if (!file_exists($fileDirectory)) {
            mkdir($fileDirectory, 777, true);
        }
    }

    public function getFileAddress()
    {
        return $this->finalFileDirectory . DIRECTORY_SEPARATOR . $this->finalFileName;
    }

    // use this method to upload File
    public function provider()
    {
        // set properties
            $this->getFileDirectory() ?? $this->setFileDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m')
            . DIRECTORY_SEPARATOR . date('d'));
            $this->getFileName() ?? $this->setFileName(time());
            $this->setFileFormat(pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION));

        // set final File directory
        $finalFileDirectory = empty($this->getExclusiveDirectory()) ? $this->getFileDirectory() :
            $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getFileDirectory();
        $this->setFinalFileDirectory($finalFileDirectory);

        // set final File name
        $this->setFinalFileName($this->getFileName() . '.' . $this->getFileFormat());

        // check and create final File directory
        $this->checkDirectory($this->getFinalFileDirectory());
    }

}

