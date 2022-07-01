<?php

namespace Tests\Helpers\Common\FileHelper;

trait FileHelperTrait
{
    /**
     * @return string
     */
    protected function getUnencryptedFilePath(): string
    {
        return FileHelper::getUnencryptedFilePath();
    }

    /**
     * @return string
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    protected function getUnencryptedFileContent(): string
    {
        return FileHelper::getUnencryptedFileContent();
    }

    /**
     * @return string
     */
    protected function getEncryptedFilePath(): string
    {
        return FileHelper::getEncryptedFilePath();
    }

    /**
     * @return string
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    protected function getEncryptedFileContent(): string
    {
        return FileHelper::getEncryptedFileContent();
    }
}
