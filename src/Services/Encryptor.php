<?php
/*
 * Copyright 2015 Soeezy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Paymaxi\DoctrineEncryptBundle\Services;

/**
 * Class Encryptor
 *
 * @package Paymaxi\DoctrineEncryptBundle\Services
 */
class Encryptor
{
    /** @var \Paymaxi\DoctrineEncryptBundle\Encryptors\EncryptorInterface */
    protected $encryptor;

    /**
     * Encryptor constructor.
     *
     * @param $encryptName
     * @param $key
     *
     * @throws \ReflectionException
     */
    public function __construct($encryptName, $key)
    {
        $reflectionClass = new \ReflectionClass($encryptName);
        $this->encryptor = $reflectionClass->newInstanceArgs([
            $key
        ]);
    }

    /**
     * @return \Paymaxi\DoctrineEncryptBundle\Encryptors\EncryptorInterface|object
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function decrypt($string): string
    {
        return $this->encryptor->decrypt($string);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function encrypt($string): string
    {
        return $this->encryptor->encrypt($string);
    }
}
