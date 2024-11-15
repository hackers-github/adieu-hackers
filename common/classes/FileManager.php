<?php

namespace classes;

use \classes\S3Uploader;

class FileManager
{
    private $bucket = 'hackersac-cdn';

    public function upload($file, $dir) {
        if(!$file || !$dir) {
            return false;
        }

        $s3Uploader = new S3Uploader($file, $dir, $this->bucket);
        $s3Uploader->setAllowSize(1048576); // 1MB Á¦ÇÑ
        return $s3Uploader->upload();
    }
}