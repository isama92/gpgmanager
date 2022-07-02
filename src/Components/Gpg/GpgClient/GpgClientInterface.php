<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface;
use gnupg;

interface GpgClientInterface
{
    /**
     * @param string $privateKeyPath
     * @param string $passphrase
     *
     * @return void
     */
    public function addPrivateKey(string $privateKeyPath, string $passphrase = ''): void;

    /**
     * @param string $publicKeyPath
     *
     * @return void
     */
    public function addPublicKey(string $publicKeyPath): void;

    /**
     * @param string $privateKeyPath
     * @param string $publicKeyPath
     * @param string $privateKeyPassphrase
     *
     * @return void
     */
    public function addBothKeys(string $privateKeyPath, string $publicKeyPath, string $privateKeyPassphrase = ''): void;

    /**
     * @param string $data
     *
     * @return string
     */
    public function encrypt(string $data): string;

    /**
     * @param string $data
     *
     * @return string
     */
    public function encryptSign(string $data): string;

    /**
     * @param string $data
     *
     * @return string
     */
    public function decrypt(string $data): string;

    /**
     * @return \gnupg
     */
    public function getClient(): gnupg;

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface|null
     */
    public function getPrivateKey(): ?PrivateGpgKeyInterface;

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface|null
     */
    public function getPublicKey(): ?PublicGpgKeyInterface;
}
