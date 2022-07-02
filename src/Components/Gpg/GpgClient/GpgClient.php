<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\DecryptionFailedException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\EncryptionFailedException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\EncryptionSignFailedException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyNotSetException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyNotSetException;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKey;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKey;
use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;

class GpgClient implements GpgClientInterface
{
    use GnupgFactoryMethod;

    /**
     * @var \gnupg
     */
    protected gnupg $client;

    /**
     * @var \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface
     */
    protected PrivateGpgKeyInterface $privateKey;

    /**
     * @var \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface
     */
    protected PublicGpgKeyInterface $publicKey;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = $this->createGnupg();
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface
     */
    protected function createPrivateGpgKey(): PrivateGpgKeyInterface
    {
        return new PrivateGpgKey($this->client);
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface
     */
    protected function createPublicGpgKey(): PublicGpgKeyInterface
    {
        return new PublicGpgKey($this->client);
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     */
    public function addPrivateKey(string $privateKeyPath, string $passphrase = ''): void
    {
        if (isset($this->privateKey)) {
            throw new PrivateGpgKeyAlreadySetException();
        }

        $key = $this->createPrivateGpgKey();
        $key->readFromPath($privateKeyPath);

        $fingerprint = $key->getFingerprint();
        $this->client->addDecryptKey($fingerprint, $passphrase);
        $this->client->addSignKey($fingerprint, $passphrase);

        $this->privateKey = $key;
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     */
    public function addPublicKey(string $publicKeyPath): void
    {
        if (isset($this->publicKey)) {
            throw new PublicGpgKeyAlreadySetException();
        }

        $key = $this->createPublicGpgKey();
        $key->readFromPath($publicKeyPath);

        $this->client->addEncryptKey($key->getFingerprint());

        $this->publicKey = $key;
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     */
    public function addBothKeys(string $privateKeyPath, string $publicKeyPath, string $privateKeyPassphrase = ''): void
    {
        $this->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
        $this->addPublicKey($publicKeyPath);
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\EncryptionFailedException
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyNotSetException
     */
    public function encrypt(string $data): string
    {
        if (!isset($this->publicKey)) {
            throw new PublicGpgKeyNotSetException();
        }

        /**
         * @var string|false $encryptedData
         */
        $encryptedData = $this->client->encrypt($data);

        // save memory
        unset($data);

        if ($encryptedData === false) {
            throw new EncryptionFailedException();
        }

        return $encryptedData;
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\EncryptionSignFailedException
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyNotSetException
     */
    public function encryptSign(string $data): string
    {
        if (!isset($this->privateKey)) {
            throw new PrivateGpgKeyNotSetException();
        }

        if (!isset($this->publicKey)) {
            throw new PublicGpgKeyNotSetException();
        }

        /**
         * @var string|false $encryptedData
         */
        $encryptedData = $this->client->encryptSign($data);

        // save memory
        unset($data);

        if ($encryptedData === false) {
            throw new EncryptionSignFailedException();
        }

        return $encryptedData;
    }

    /**
     * @inheritDoc
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\DecryptionFailedException
     * @throws \Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     */
    public function decrypt(string $data): string
    {
        if (!isset($this->privateKey)) {
            throw new PrivateGpgKeyNotSetException();
        }

        /**
         * @var string|false $decryptedData
         */
        $decryptedData = $this->client->decrypt($data);

        // save memory
        unset($data);

        if ($decryptedData === false) {
            throw new DecryptionFailedException();
        }

        return $decryptedData;
    }

    /**
     * @inheritDoc
     */
    public function getClient(): gnupg
    {
        return $this->client;
    }

    /**
     * @inheritDoc
     */
    public function getPrivateKey(): ?PrivateGpgKeyInterface
    {
        return $this->privateKey ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getPublicKey(): ?PublicGpgKeyInterface
    {
        return $this->publicKey ?? null;
    }
}
