<?php

namespace Borzoni\GpgManager\Components\GpgKey;

use Borzoni\SBFile\Components\SBFile\SBFile;
use gnupg;

abstract class GpgKey
{
    /**
     * @var \gnupg
     */
    protected $client;

    /**
     * @var int
     */
    protected $imported;

    /**
     * @var int
     */
    protected $unchanged;

    /**
     * @var int
     */
    protected $newuserids;

    /**
     * @var int
     */
    protected $newsubkeys;

    /**
     * @var int
     */
    protected $secretimported;

    /**
     * @var int
     */
    protected $secretunchanged;

    /**
     * @var int
     */
    protected $newsignatures;

    /**
     * @var int
     */
    protected $skippedkeys;

    /**
     * @var string
     */
    protected $fingerprint;

    /**
     * Constructor
     *
     * @param \gnupg $client
     */
    public function __construct(gnupg $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $path
     * @param string $mode
     *
     * @return \Borzoni\SBFile\Components\SBFile\SBFile
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    protected function createSBFile(string $path, string $mode): SBFile
    {
        return new SBFile($path, $mode);
    }

    /**
     * @param string $path
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    public function readFromPath(string $path): void
    {
        $SBFile = $this->createSBFile($path, SBFile::MODE_R);
        $content = $SBFile->read();
        $this->import($content);
    }

    /**
     * @param string $key
     *
     * @return void
     */
    protected function import(string $key): void
    {
        $res = $this->client->import($key);
        $this->setImported($res['imported']);
        $this->setUnchanged($res['unchanged']);
        $this->setNewuserids($res['newuserids']);
        $this->setNewsubkeys($res['newsubkeys']);
        $this->setSecretimported($res['secretimported']);
        $this->setSecretunchanged($res['secretunchanged']);
        $this->setNewsignatures($res['newsignatures']);
        $this->setSkippedkeys($res['skippedkeys']);
        $this->setFingerprint($res['fingerprint']);
    }

    /**
     * @return int
     */
    public function getImported(): int
    {
        return $this->imported;
    }

    /**
     * @param int $imported
     */
    public function setImported(int $imported): void
    {
        $this->imported = $imported;
    }

    /**
     * @return int
     */
    public function getUnchanged(): int
    {
        return $this->unchanged;
    }

    /**
     * @param int $unchanged
     */
    public function setUnchanged(int $unchanged): void
    {
        $this->unchanged = $unchanged;
    }

    /**
     * @return int
     */
    public function getNewuserids(): int
    {
        return $this->newuserids;
    }

    /**
     * @param int $newuserids
     */
    public function setNewuserids(int $newuserids): void
    {
        $this->newuserids = $newuserids;
    }

    /**
     * @return int
     */
    public function getNewsubkeys(): int
    {
        return $this->newsubkeys;
    }

    /**
     * @param int $newsubkeys
     */
    public function setNewsubkeys(int $newsubkeys): void
    {
        $this->newsubkeys = $newsubkeys;
    }

    /**
     * @return int
     */
    public function getSecretimported(): int
    {
        return $this->secretimported;
    }

    /**
     * @param int $secretimported
     */
    public function setSecretimported(int $secretimported): void
    {
        $this->secretimported = $secretimported;
    }

    /**
     * @return int
     */
    public function getSecretunchanged(): int
    {
        return $this->secretunchanged;
    }

    /**
     * @param int $secretunchanged
     */
    public function setSecretunchanged(int $secretunchanged): void
    {
        $this->secretunchanged = $secretunchanged;
    }

    /**
     * @return int
     */
    public function getNewsignatures(): int
    {
        return $this->newsignatures;
    }

    /**
     * @param int $newsignatures
     */
    public function setNewsignatures(int $newsignatures): void
    {
        $this->newsignatures = $newsignatures;
    }

    /**
     * @return int
     */
    public function getSkippedkeys(): int
    {
        return $this->skippedkeys;
    }

    /**
     * @param int $skippedkeys
     */
    public function setSkippedkeys(int $skippedkeys): void
    {
        $this->skippedkeys = $skippedkeys;
    }

    /**
     * @return string
     */
    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    /**
     * @param string $fingerprint
     */
    public function setFingerprint(string $fingerprint): void
    {
        $this->fingerprint = $fingerprint;
    }
}
