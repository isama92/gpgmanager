<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgManager;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface;

interface GpgManagerInterface
{
    /**
     * @param string $clientCode
     *
     * @return bool
     */
    public function clientExists(string $clientCode): bool;

    /**
     * @param \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface $client
     * @param string                                                          $clientCode
     *
     * @return void
     */
    public function addClient(GpgClientInterface $client, string $clientCode): void;

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface[]
     */
    public function getClients(): array;

    /**
     * @param string $clientCode
     *
     * @return \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface
     */
    public function getClient(string $clientCode): GpgClientInterface;

    /**
     * @param string $clientCode
     *
     * @return void
     */
    public function deleteClient(string $clientCode): void;

    /**
     * @param string $privateKeyPath
     * @param string $clientCode
     * @param string $passphrase
     *
     * @return void
     */
    public function createWithPrivateKey(string $privateKeyPath, string $clientCode, string $passphrase = ''): void;

    /**
     * @param string $publicKeyPath
     * @param string $clientCode
     *
     * @return void
     */
    public function createWithPublicKey(string $publicKeyPath, string $clientCode): void;

    /**
     * @param string $privateKeyPath
     * @param string $publicKeyPath
     * @param string $clientCode
     * @param string $privateKeyPassphrase
     *
     * @return void
     */
    public function createWithBothKeys(
        string $privateKeyPath,
        string $publicKeyPath,
        string $clientCode,
        string $privateKeyPassphrase = ''
    ): void;
}
