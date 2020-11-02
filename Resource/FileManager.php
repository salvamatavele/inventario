<?php

namespace Resource;

use CoffeeCode\Uploader\File;
use Resource\Validator;
use CoffeeCode\Uploader\Image;
use CoffeeCode\Uploader\Send;

class FileManager
{
    private $uploadedPath;
    private $uploadedsPath = [];
    private $Error;

    /**
     * Get the value of uploadedPath
     */
    public function getUploadedPath()
    {
        return $this->uploadedPath;
    }

    /**
     * Set the value of uploadedPath
     *
     * @return  self
     */
    public function setUploadedPath($uploadedPath)
    {
        $this->uploadedPath = $uploadedPath;

        return $this;
    }

    /**
     * Get the value of uploadedsPath
     */
    public function getUploadedsPath()
    {
        return $this->uploadedsPath;
    }

    /**
     * Set the value of uploadedsPath
     *
     * @return  self
     */
    public function setUploadedsPath($uploadedsPath)
    {
        array_push($this->uploadedsPath, $uploadedsPath);
    }

    /**
     * Get the value of Error
     */
    public function getError()
    {
        return $this->Error;
    }

    /**
     * Set the value of Error
     *
     * @return  self
     */
    public function setError($Error)
    {
        $this->Error = $Error;

        return $this;
    }
    /**
     * Upload single image file
     *
     * @param [type] $image
     * @param [type] $dirFolder
     *  [type] $size
     * @return void
     */
    public function uploadSingleImage(array $image, string $folder = "Public/storage", int $size=1920)
    {
        $validate = new Validator();
        $validate->validateFields(['image' => $image['image']]);
        $files = $_FILES;
        $upload = new Image($folder, 'images');
        //if not empty image
        if (empty($validate->getErrors())) {
            $file = $files['image'];
            if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
                $this->setError('The image type is invalid '.$file['name']);
                return false;
            } else {
                # code...
                $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), $size);
                if ($uploaded) {
                    $this->setUploadedPath($uploaded);
                    return true;
                }
                $this->setError('IS not possible to save ' . $file['name']." change permition to folder ".$folder);
                return false;
            }
        } else {
            $this->setError('Please select an image file');
            return false;
        }
    }
    /**
     * Upload Multiple images file and single
     *
     *  [type] $image
     *  [type] $dirFolder
     *  [type] $size
     * @return void
     */
    public function uploadMultipleImages(array $image, string $folder = "Public/storage", int $size=1920)
    {
        $validate = new Validator();
        $validate->validateFields(['images' => $image['images']]);
        $files = $_FILES;
        $upload = new Image($folder, 'images');
        //if not empty image
        if (empty($validate->getErrors())) {
            $images = $files['images'];
            for ($i = 0; $i < count($images['type']); $i++) {
                foreach (array_keys($images) as $keys) {
                    $imageFiles[$i][$keys] = $images[$keys][$i];
                }
            }
            foreach ($imageFiles as $file) {
                if (empty($file['type'])) {
                    $this->setError("Please  select an image file");
                    return false;
                } elseif (!in_array($file['type'], $upload::isAllowed())) {
                    $this->Error .= "The file " . $file['name'] . " is not an image file \n";
                }
            }

            if (empty($this->Error)) {
                foreach ($imageFiles as $file) {
                    $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), $size);
                    $this->setUploadedsPath($uploaded);
                }
                return true;
            } else {
                return false;
            }
        } else {
            $this->setError('Please select an image file or change de input file image name and put image[]');
            return false;
        }
    }
    /**
     * Upload single file (pdf tar zar zip rar)
     *
     * @param [type] $image
     *  [type] $dirFolder
     *  [type] $size
     * @return void
     */
    public function uploadSingleFile(array $file, string $folder, int $size)
    {
        $validate = new Validator();
        $validate->validateFields(['file' => $file['file']]);
        $files = $_FILES;
        $upload = new File($folder, 'files');
        //if not empty file
        if (empty($validate->getErrors())) {
            $file = $files['file'];
            if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
                $this->setError('The file type is invalid');
                return false;
            } else {
                # code...
                $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), $size);
                if ($uploaded) {
                    $this->setUploadedPath($uploaded);
                    return true;
                }
                $this->setError('IS not possible to save ' . $file['name']." change permition to folder ".$folder);
                return false;
            }
        } else {
            $this->setError('Please select an file or change de input file  name and put file');
            return false;
        }
    }
    /**
     * upload single videos and musics
     *
     * @param [type] $media
     *  [type] $folder
     *  [type] $size
     * @return void
     */
    public function uploadSingleMedia(array $media, string $folder, int $size)
    {
        $validate = new Validator();
        $validate->validateFields(['media' => $media['media']]);
        $files = $_FILES;
        $upload = new Send($folder, 'medias', [
            "audio/mpeg",
            "audio/mp3",
            "video/mp4"
        ]);
        //if not empty file
        if (empty($validate->getErrors())) {
            $file = $files['media'];
            if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
                $this->setError('The media type is invalid '.$file['name']);
                return false;
            } else {
                # code...
                $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), $size);
                if ($uploaded) {
                    $this->setUploadedPath($uploaded);
                    return true;
                }
                $this->setError('IS not possible to save ' . $file['name']." change permition to folder ".$folder);
                return false;
            }
        } else {
            $this->setError('Please select an media file or change media file name and rename media');
            return false;
        }
    }
    /**
     * upload ather type of files 
     *
     *  [type] $media
     * [type] $folder
     * [type] $size
     * [type] $extetions 
     * ["audio/mpeg","audio/mp3","video/mp4", ]
     * @return void
     */
    public function uploadOther(array $media, string $folder, int $size, array $extetions)
    {
        $validate = new Validator();
        $validate->validateFields(['media' => $media['media']]);
        $files = $_FILES;
        $upload = new Send($folder, 'medias', $extetions);
        //if not empty file
        if (empty($validate->getErrors())) {
            $file = $files['media'];
            if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
                $this->setError('The media type is invalid '.$file['name']);
                return false;
            } else {
                # code...
                $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), $size);
                if ($uploaded) {
                    $this->setUploadedPath($uploaded);
                    return true;
                }
                $this->setError('IS not possible to save ' . $file['name']." change permition to folder ".$folder);
                return false;
            }
        } else {
            $this->setError('Please select an media');
            return false;
        }
    }

    /**
     * delete files acording to the location given.
     *
     * @param string $fileName
     * @return void
     */
    public function deleteFiles( string $fileName)
    {
 
        if (unlink($fileName)) {
            return true;
        } else {
            $this->setError('Ooops...Error to delete ' . $fileName);
            return false;
        }
    }

    /**
     * upload single image
     *
     * [type] $image
     * [type] $folder
     * [type] $size
     * [type] $fileName
     * void
     */
    public function updateSingleImage($image, $folder, $size, $fileName)
    {
        $validate = new Validator();
        $validate->validateFields(['image' => $image['image']]);
        $files = $_FILES;
        $upload = new Image($folder, 'images');
        //if not empty image
        if (empty($validate->getErrors())) {
            $file = $files['image'];
            if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
                $this->setError('The image type is invalid ' . $file['name']);
                return false;
            } else {
                # code...
                $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), $size);
                if ($uploaded) {
                    $this->setUploadedPath($uploaded);
                    if (unlink($fileName)) {
                        return true;
                    } else {
                        $this->setError('Ooops...Error to delete ' . $fileName);
                        return false;
                    }
                    
                }
                $this->setError('IS not possible to save ' . $file['name']." change permition to folder ".$folder);
                return false;
            }
        } else {
            $this->setError('Please select an image or change de input file image name');
            return false;
        }
    }
}
