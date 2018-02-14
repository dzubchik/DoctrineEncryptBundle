<?php

namespace Paymaxi\DoctrineEncryptBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Paymaxi\DoctrineEncryptBundle\DependencyInjection\DoctrineEncryptExtension;

class PaymaxiDoctrineEncryptBundle extends Bundle {
    
    public function getContainerExtension()
    {
        return new DoctrineEncryptExtension();
    }
}
