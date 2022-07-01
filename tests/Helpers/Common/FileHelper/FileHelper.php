<?php

namespace Tests\Helpers\Common\FileHelper;

use Borzoni\SBFile\Components\SBFile\SBFile;

class FileHelper
{
    protected const DIR_NAME = 'files';
    protected const FILE_UNENCRYPTED = 'file.txt';
    protected const FILE_ENCRYPTED = 'file.txt.pgp';

    /**
     * @return string
     */
    public static function getUnencryptedFilePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self::DIR_NAME . DIRECTORY_SEPARATOR . self::FILE_UNENCRYPTED;
    }

    /**
     * @return string
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    public static function getUnencryptedFileContent(): string
    {
        $filePath = self::getUnencryptedFilePath();
        $file = new SBFile($filePath, SBFile::MODE_R);
        return $file->read();
    }

    /**
     * @return string
     */
    public static function getEncryptedFilePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self::DIR_NAME . DIRECTORY_SEPARATOR . self::FILE_ENCRYPTED;
    }

    /**
     * @return string
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    public static function getEncryptedFileContent(): string
    {
        $filePath = self::getEncryptedFilePath();
        $file = new SBFile($filePath, SBFile::MODE_R);
        return $file->read();
    }
}
