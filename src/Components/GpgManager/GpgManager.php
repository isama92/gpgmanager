<?php

namespace Borzoni\GpgManager\Components\GpgManager;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException;

class GpgManager
{
    /**
     * @var \Borzoni\GpgManager\Components\GpgClient\GpgClient[]
     */
    protected $clients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initClients();
    }

    /**
     * @return void
     */
    protected function initClients(): void
    {
        $this->clients = [];
    }

    /**
     * @param string $clientCode
     *
     * @return bool
     */
    public function clientExists(string $clientCode): bool
    {
        return isset($this->clients[$clientCode]);
    }

    /**
     * @param \Borzoni\GpgManager\Components\GpgClient\GpgClient $client
     * @param string                                                 $clientCode
     *
     * @return void
     */
    public function addClient(GpgClient $client, string $clientCode): void
    {
        $this->clients[$clientCode] = $client;
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgClient\GpgClient[]
     */
    public function getClients(): array
    {
        return $this->clients;
    }

    /**
     * @param string $clientCode
     *
     * @return \Borzoni\GpgManager\Components\GpgClient\GpgClient
     * @throws \Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function getClient(string $clientCode): GpgClient
    {
        if (!$this->clientExists($clientCode)) {
            throw new GpgClientNotFoundException($clientCode);
        }
        return $this->clients[$clientCode];
    }

    /**
     * @param string $clientCode
     *
     * @return void
     * @throws \Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function deleteClient(string $clientCode): void
    {
        if (!$this->clientExists($clientCode)) {
            throw new GpgClientNotFoundException($clientCode);
        }

        unset($this->clients[$clientCode]);
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgClient\GpgClient
     */
    protected function createGpgClient(): GpgClient
    {
        return new GpgClient();
    }

    /**
     * @param string $privateKeyPath
     * @param string $clientCode
     * @param string $passphrase
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     */
    public function createWithPrivateKey(string $privateKeyPath, string $clientCode, string $passphrase = ''): void
    {
        $client = $this->createGpgClient();
        $client->addPrivateKey($privateKeyPath, $passphrase);
        $this->addClient($client, $clientCode);
    }

    /**
     * @param string $publicKeyPath
     * @param string $clientCode
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     */
    public function createWithPublicKey(string $publicKeyPath, string $clientCode): void
    {
        $client = $this->createGpgClient();
        $client->addPublicKey($publicKeyPath);
        $this->addClient($client, $clientCode);
    }

    /**
     * @param string $privateKeyPath
     * @param string $publicKeyPath
     * @param string $clientCode
     * @param string $privateKeyPassphrase
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     */
    public function createWithBothKeys(string $privateKeyPath, string $publicKeyPath, string $clientCode, string $privateKeyPassphrase = ''): void
    {
        $client = $this->createGpgClient();
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);
        $this->addClient($client, $clientCode);
    }
}
