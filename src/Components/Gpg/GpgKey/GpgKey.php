<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgKey;

use Borzoni\SBFile\Components\SBFile\FileInterface;
use Borzoni\SBFile\Components\SBFile\SBFile;
use gnupg;

abstract class GpgKey implements GpgKeyInterface
{
    /**
     * @var \gnupg
     */
    protected gnupg $client;

    /**
     * @var int
     */
    protected int $imported;

    /**
     * @var int
     */
    protected int $unchanged;

    /**
     * @var int
     */
    protected int $newuserids;

    /**
     * @var int
     */
    protected int $newsubkeys;

    /**
     * @var int
     */
    protected int $secretimported;

    /**
     * @var int
     */
    protected int $secretunchanged;

    /**
     * @var int
     */
    protected int $newsignatures;

    /**
     * @var int
     */
    protected int $skippedkeys;

    /**
     * @var string
     */
    protected string $fingerprint;

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
    protected function createSBFile(string $path, string $mode): FileInterface
    {
        return new SBFile($path, $mode);
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
     * @inheritDoc
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    public function readFromPath(string $path): void
    {
        $SBFile = $this->createSBFile($path, FileInterface::MODE_R);
        $content = $SBFile->read();
        $this->import($content);
    }

    /**
     * @inheritDoc
     */
    public function getImported(): int
    {
        return $this->imported;
    }

    /**
     * @inheritDoc
     */
    public function setImported(int $imported): void
    {
        $this->imported = $imported;
    }

    /**
     * @inheritDoc
     */
    public function getUnchanged(): int
    {
        return $this->unchanged;
    }

    /**
     * @inheritDoc
     */
    public function setUnchanged(int $unchanged): void
    {
        $this->unchanged = $unchanged;
    }

    /**
     * @inheritDoc
     */
    public function getNewuserids(): int
    {
        return $this->newuserids;
    }

    /**
     * @inheritDoc
     */
    public function setNewuserids(int $newuserids): void
    {
        $this->newuserids = $newuserids;
    }

    /**
     * @inheritDoc
     */
    public function getNewsubkeys(): int
    {
        return $this->newsubkeys;
    }

    /**
     * @inheritDoc
     */
    public function setNewsubkeys(int $newsubkeys): void
    {
        $this->newsubkeys = $newsubkeys;
    }

    /**
     * @inheritDoc
     */
    public function getSecretimported(): int
    {
        return $this->secretimported;
    }

    /**
     * @inheritDoc
     */
    public function setSecretimported(int $secretimported): void
    {
        $this->secretimported = $secretimported;
    }

    /**
     * @inheritDoc
     */
    public function getSecretunchanged(): int
    {
        return $this->secretunchanged;
    }

    /**
     * @inheritDoc
     */
    public function setSecretunchanged(int $secretunchanged): void
    {
        $this->secretunchanged = $secretunchanged;
    }

    /**
     * @inheritDoc
     */
    public function getNewsignatures(): int
    {
        return $this->newsignatures;
    }

    /**
     * @inheritDoc
     */
    public function setNewsignatures(int $newsignatures): void
    {
        $this->newsignatures = $newsignatures;
    }

    /**
     * @inheritDoc
     */
    public function getSkippedkeys(): int
    {
        return $this->skippedkeys;
    }

    /**
     * @inheritDoc
     */
    public function setSkippedkeys(int $skippedkeys): void
    {
        $this->skippedkeys = $skippedkeys;
    }

    /**
     * @inheritDoc
     */
    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    /**
     * @inheritDoc
     */
    public function setFingerprint(string $fingerprint): void
    {
        $this->fingerprint = $fingerprint;
    }
}
