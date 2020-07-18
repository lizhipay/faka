<?php
declare (strict_types=1);

namespace App\Service;


interface UploadServiceInterface
{
    /**
     * 文件上传
     * @param $upload
     * @param $dir
     * @param $type
     * @param int $size
     * @param string $file_name
     * @return array
     */
    public function handle($upload, $dir, $type, int $size = 10000, string $file_name = '');
}