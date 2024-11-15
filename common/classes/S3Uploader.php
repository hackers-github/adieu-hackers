<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2023-08-04
 * Time: 오후 2:20
 */
namespace classes;

if(file_exists('/home/web/vendor/autoload.php')){
    require_once '/home/web/vendor/autoload.php';

}

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3Uploader
{
    private $s3 = [];
    private $s3Client;

    private $file;
    private $fileExt;
    private $saveFileName;
    private $allowExt = ['gif', 'jpg', 'jpeg', 'png', 'bmp', 'zip', 'ppt', 'docx', 'doc', 'hwp', 'mp3', 'mp4', 'wmv', 'm4a', 'ogg', 'pptx', 'pdf', 'mov', 'xlsx', 'xls', 'avi', 'smi', 'csv'];
    private $allowSize = 209715200; // 200mbs
    private $directoryPath; // 저장 경로
    
    public function __construct($file, $dir, $s3Bucket)
    {
        // S3 설정
        $this->setS3($s3Bucket);
        $this->s3Client = S3Client::factory($this->s3['factory']);

        // 파일정보 세팅
        $this->file = $file;
        $this->fileExt = strtolower($this->getExt($this->file['name']));
        $this->saveFileName = md5($this->uniqueTimeStamp()) . "." . $this->fileExt;

        // 저장경로 설정
        $this->directoryPath = $this->makeDirectoryPath($dir . '/' . $this->saveFileName);
    }

    public function upload() {
        $returnData = [];
        $returnData['result'] = false;

        if(!$this->file || !$this->directoryPath) {
            $returnData['msg'] = '필수 값 없음';
            return $returnData;
        }

        if(!in_array(strtolower($this->fileExt), $this->allowExt)) {
            $returnData['msg'] = '허용되지 않은 확장자';
            return $returnData;
        }

        if($this->file['size'] > $this->allowSize) {
            $mb = ($this->allowSize / 1024) / 1024;
            $returnData['msg'] = $mb . 'MB 이하의 파일만 업로드 가능합니다.';
            return $returnData;
        }

        // 이미지 메타 데이터
        $imageMetaData = getimagesize($this->file['tmp_name']);

        // 파일을 S3에 저장
        $putResult = $this->putObject($this->file, $this->directoryPath);
        if(!$putResult) {
            $returnData['msg'] = '업로드 실패';
            return $returnData;
        }

        // 값 리턴
        $returnData['result'] = true;
        $returnData['msg'] = '업로드 완료';
        $returnData['name'] = $this->saveFileName;
        $returnData['url'] = $this->s3['url'] . '/' . $this->directoryPath;
        $returnData['directoryPath'] = $this->directoryPath;
        $returnData['meta'] = $imageMetaData;
        return $returnData;
    }

    /**
     * @param array $allowExt
     */
    public function setAllowExt($allowExt)
    {
        $this->allowExt = $allowExt;
    }

    /**
     * @param int $allowSize
     */
    public function setAllowSize($allowSize)
    {
        $this->allowSize = $allowSize;
    }

    /**
     * @param string $saveFileName
     */
    public function setSaveFileName($saveFileName)
    {
        $this->saveFileName = $saveFileName;
    }

    private function putObject($file, $directoryPath) {
        if(!$file || !$this->s3Client || !$this->s3['bucket'] || !$directoryPath) {
            return false;
        }

        // 저장될 파일명
        try {
            $result = $this->s3Client->putObject(array(
                'Bucket' => $this->s3['bucket'],
                'Key'    => $directoryPath,
                'Body'   => fopen($file['tmp_name'], 'r'),
                'ContentType'  =>  $file['type']
            ));

            // S3 파일 업로드 후 파일 삭제
            if (is_file($file['tmp_name'])) {
                @unlink($file['tmp_name']);
            }
        } catch (S3Exception $e) {
            echo $e;
            return false;
        }
        return $result;
    }

    private function setS3($s3Bucket) {
        // S3 업로드 설정
        $this->s3['url'] = "https://cdn.hackers.ac";  // s3 cloudfront 도메인
        $this->s3['bucket'] = $s3Bucket; // 버킷명
        $this->s3['factory']['suppress_php_deprecation_warning'] = true;
        $this->s3['factory']['region'] = "ap-northeast-2"; // 고정
        $this->s3['factory']['version'] = "latest"; // 고정
        $this->s3['factory']['signature'] = "v4"; // 고정
    }

    private function getExt($name) {
        $nx=explode('.',$name);
        return $nx[count($nx)-1];
    }

    private function uniqueTimeStamp() {
        list($msec, $sec) = explode(" ", microtime());
        $msec = explode(".", $msec);
        return $sec.substr(array_pop($msec), 0, 4);
    }

    private function makeDirectoryPath($directoryPath) {
        $directoryPathArr = explode('/', $directoryPath);
        if(in_array($directoryPathArr[0], ['upload-test', 'upload'])) {
            return $directoryPath;
        }

        // 저장경로 설정
        if(in_array($_SERVER['HTTP_HOST'], ['tdevadieu2024.hackers.com'])) {
            $directoryPath = 'upload-test/' . $directoryPath;
        } else {
            $directoryPath = 'upload/' . $directoryPath;
        }
        return $directoryPath;
    }
}