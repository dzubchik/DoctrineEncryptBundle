<?php

namespace Paymaxi\DoctrineEncryptBundle;

use Paymaxi\DoctrineEncryptBundle\DependencyInjection\DoctrineEncryptExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineEncryptBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DoctrineEncryptExtension();
    }
}
