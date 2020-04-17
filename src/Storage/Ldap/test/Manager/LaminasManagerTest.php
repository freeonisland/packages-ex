<?php

namespace Ldap\Manager;

use PHPUnit\Framework\TestCase;

class LaminasManagerTest extends TestCase
{
    private $bundle;

    public function setUp(): void
    {
        $this->bundle = new \App\Core\Bundle('Ldap');
    }

    public function testCreateAndDestroy()
    {
        $this->assertTrue(true);
        $lm = $this->bundle->getModule('LaminasManager');
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