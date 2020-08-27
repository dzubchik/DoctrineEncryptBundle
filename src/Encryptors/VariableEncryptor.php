<?php

namespace Paymaxi\DoctrineEncryptBundle\Encryptors;

/**
 * Class for variable encryption.
 *
 * @author Victor Melnik <melnikvictorl@gmail.com>
 */
class VariableEncryptor implements EncryptorInterface
{
    public const ENCRYPT_METHOD = 'AES-256-ECB';

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var string|false
     */
    private $initializationVector = false;

    /**
     * {@inheritdoc}
     */
    public function __construct($key)
    {
        $this->secretKey = md5($key);
        $length = openssl_cipher_iv_length(self::ENCRYPT_METHOD);

        if (0 !== (int)$length) {
            $this->initializationVector = openssl_random_pseudo_bytes($length);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($data)
    {
        if (\is_string($data)) {
            return trim(base64_encode(openssl_encrypt(
                $data,
                self::ENCRYPT_METHOD,
                $this->secretKey,
                0,
                $this->initializationVector
            ))).'<ENC>';
        }

        /*
         * Use ROT13 which is an simple letter substitution cipher with some additions
         * Not the safest option but it makes it alot harder for the attacker
         *
         * Not used, needs improvement or other solution
         */
        if (\is_int($data)) {
            //Not sure
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($data)
    {
        if (\is_string($data)) {
            $data = str_replace('<ENC>', '', $data);

            return trim(openssl_decrypt(
                base64_decode($data),
                self::ENCRYPT_METHOD,
                $this->secretKey,
                0,
                $this->initializationVector
            ));
        }

        return $data;
    }
}
