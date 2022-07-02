<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgKey;

interface GpgKeyInterface
{
    /**
     * @param string $path
     *
     * @return void
     */
    public function readFromPath(string $path): void;


    /**
     * @return int
     */
    public function getImported(): int;

    /**
     * @param int $imported
     */
    public function setImported(int $imported): void;

    /**
     * @return int
     */
    public function getUnchanged(): int;

    /**
     * @param int $unchanged
     */
    public function setUnchanged(int $unchanged): void;

    /**
     * @return int
     */
    public function getNewuserids(): int;

    /**
     * @param int $newuserids
     */
    public function setNewuserids(int $newuserids): void;

    /**
     * @return int
     */
    public function getNewsubkeys(): int;

    /**
     * @param int $newsubkeys
     */
    public function setNewsubkeys(int $newsubkeys): void;

    /**
     * @return int
     */
    public function getSecretimported(): int;

    /**
     * @param int $secretimported
     */
    public function setSecretimported(int $secretimported): void;

    /**
     * @return int
     */
    public function getSecretunchanged(): int;

    /**
     * @param int $secretunchanged
     */
    public function setSecretunchanged(int $secretunchanged): void;

    /**
     * @return int
     */
    public function getNewsignatures(): int;

    /**
     * @param int $newsignatures
     */
    public function setNewsignatures(int $newsignatures): void;

    /**
     * @return int
     */
    public function getSkippedkeys(): int;

    /**
     * @param int $skippedkeys
     */
    public function setSkippedkeys(int $skippedkeys): void;

    /**
     * @return string
     */
    public function getFingerprint(): string;

    /**
     * @param string $fingerprint
     */
    public function setFingerprint(string $fingerprint): void;
}
