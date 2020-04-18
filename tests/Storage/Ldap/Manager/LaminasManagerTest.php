<?php

namespace App\Storage\Ldap\Manager;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LaminasManagerTest extends WebTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testCreateAndDestroy()
    {
        $this->assertTrue(true);
        

        $container = self::$kernel->getContainer();
        $lm = $container->get('App\Storage\Ldap\Manager\LaminasManager');

        $ldap = $lm->getLdap();
        
        $cn='blablatest';
        $lm->add('person', [
            'cn' => $cn,
            'sn' => 'blablasn'
        ]);

        $dn = "cn={$cn},dc=my-company,dc=com";
        $ldap->delete($dn);
    }

    public function tearDown(): void
    {
        
    }
}