<?php

namespace Borzoni\GpgManager\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\Exceptions\DecryptionFailedException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionFailedException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException;
use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;
use Borzoni\GpgManager\Components\GpgKey\PublicGpgKey;
use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;

class GpgClient
{
    use GnupgFactoryMethod;

    /**
     * @var \gnupg
     */
    protected $client;

    /**
     * @var \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey
     */
    protected $privateKey;

    /**
     * @var \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey
     */
    protected $publicKey;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = $this->createGnupg();
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey
     */
    public function createPrivateGpgKey(): PrivateGpgKey
    {
        return new PrivateGpgKey($this->client);
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey
     */
    public function createPublicGpgKey(): PublicGpgKey
    {
        return new PublicGpgKey($this->client);
    }

    /**
     * @param string $privateKeyPath
     * @param string $passphrase
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
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
     * @param string $publicKeyPath
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
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
     * @param string $privateKeyPath
     * @param string $publicKeyPath
     * @param string $privateKeyPassphrase
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     */
    public function addBothKeys(string $privateKeyPath, string $publicKeyPath, string $privateKeyPassphrase = ''): void
    {
        $this->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
        $this->addPublicKey($publicKeyPath);
    }

    /**
     * @param string $data
     *
     * @return string
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException
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
     * @param string $data
     *
     * @return string
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException
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
     * @param string $data
     *
     * @return string
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\DecryptionFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
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
     * @return \gnupg
     */
    public function getClient(): gnupg
    {
        return $this->client;
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey
     */
    public function getPrivateKey(): ?PrivateGpgKey
    {
        return $this->privateKey;
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey
     */
    public function getPublicKey(): ?PublicGpgKey
    {
        return $this->publicKey;
    }
}
