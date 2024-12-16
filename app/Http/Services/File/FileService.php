<?php

namespace App\Http\Services\File;

use App\Constants\FileTypeValue;
use App\Http\Services\File\FileToolsService;

class FileService extends FileToolsService
{
    public function moveToPublic($file): bool|string
    {
        // set image
        $this->setFile($file);

        // execute provider
        $this->provider();

        // save image to public
        $result = $file->move(public_path($this->getFinalFileDirectory()), $this->getFinalFileName());

        return $result ? $this->getFileAddress() : false;
    }

    public function moveToStorage($file): bool|string
    {
        // set image
        $this->setFile($file);

        // execute provider
        $this->provider();

        // save image to public
        $result = $file->move(storage_path($this->getFinalFileDirectory()), $this->getFinalFileName());

        return $result ? $this->getFileAddress() : false;
    }


    public function deleteFile($filePath, $storage = false): bool
    {
        if ($storage) {
            unlink(storage_path($filePath));
            return true;
        }
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }
        return false;
    }

    public function moveFileToNewLocation($filePath, $currentLocation, $newLocation): bool
    {
        $currentPath = $this->getFilePath($filePath, $currentLocation);
        $newPath = $this->getFilePath($filePath, $newLocation);

        if (file_exists($currentPath)) {
            // If the current and new paths differ, handle the move
            if ($currentPath !== $newPath) {
                if ($currentLocation === FileTypeValue::PUBLIC_FILE && $newLocation === FileTypeValue::PRIVATE_FILE) {
                    // Moving from public to private directory
                    if (copy($currentPath, $newPath)) {
                        unlink($currentPath); // Remove the file from the public directory
                        return true;
                    }
                } elseif ($currentLocation === FileTypeValue::PRIVATE_FILE && $newLocation === FileTypeValue::PUBLIC_FILE) {
                    // Moving from private to public directory
                    if (copy($currentPath, $newPath)) {
                        unlink($currentPath); // Remove the file from the private directory
                        return true;
                    }
                }
            }
        }
        return false;
    }



    private function getFilePath($filePath, $location): string
    {
        if ($location === FileTypeValue::PRIVATE_FILE) {
            return storage_path($filePath);
        } else {
            return public_path($filePath);
        }
    }



}

