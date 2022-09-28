<?php

namespace App\Service;

use League\Flysystem\FilesystemOperator;

class FileUploader {

    private $defaultStorage;

        public function __construct(FilesystemOperator $defaultStorage)
    {
        $this->defaultStorage= $defaultStorage;
    }

    public function uploadBase64File(string $base64file): string
    {
        //Decode the file name of the Image and save it in the localstorage
        $extension = explode('/' , mime_content_type($base64file))[1];
        $data = explode(',', $base64file);
        //generate file name
        $filename = sprintf('%s.%s', uniqid('product_', true), $extension);
        $this->defaultStorage->write($filename, base64_decode($data[1]));
        return $filename;
    }

} 