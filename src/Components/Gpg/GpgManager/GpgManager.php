<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgManager;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface;
use Borzoni\GpgManager\Components\Gpg\GpgManager\Exceptions\GpgClientNotFoundException;

class GpgManager implements GpgManagerInterface
{
    /**
     * @var \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient[]
     */
    protected array $clients;

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
     * @inheritDoc
     */
    public function clientExists(string $clientCode): bool
    {
        return isset($this->clients[$clientCode]);
    }

    /**
     * @inheritDoc
     */
    public function addClient(GpgClientInterface $client, string $clientCode): void
    {
        $this->clients[$clientCode] = $client;
    }

    /**
     * @inheritDoc
     */
    public function getClients(): array
    {
        return $this->clients;
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function getClient(string $clientCode): GpgClient
    {
        if (!$this->clientExists($clientCode)) {
            throw new GpgClientNotFoundException($clientCode);
        }
        return $this->clients[$clientCode];
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function deleteClient(string $clientCode): void
    {
        if (!$this->clientExists($clientCode)) {
            throw new GpgClientNotFoundException($clientCode);
        }

        unset($this->clients[$clientCode]);
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface
     */
    protected function createGpgClient(): GpgClientInterface
    {
        return new GpgClient();
    }

    /**
     * @inheritDoc
     */
    public function createWithPrivateKey(string $privateKeyPath, string $clientCode, string $passphrase = ''): void
    {
        $client = $this->createGpgClient();
        $client->addPrivateKey($privateKeyPath, $passphrase);
        $this->addClient($client, $clientCode);
    }

    /**
     * @inheritDoc
     */
    public function createWithPublicKey(string $publicKeyPath, string $clientCode): void
    {
        $client = $this->createGpgClient();
        $client->addPublicKey($publicKeyPath);
        $this->addClient($client, $clientCode);
    }

    /**
     * @inheritDoc
     */
    public function createWithBothKeys(
        string $privateKeyPath,
        string $publicKeyPath,
        string $clientCode,
        string $privateKeyPassphrase = ''
    ): void {
        $client = $this->createGpgClient();
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);
        $this->addClient($client, $clientCode);
    }
}
