<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Tests\Security\User;

use LitGroup\Bundle\UserBundle\Security\User\EmailUserProvider;

class EmailUserProviderTest extends UserProviderTestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->userProvider = new EmailUserProvider($this->userManager);
    }

    public function testLoadUserByUserName()
    {
        $user     = $this->getMockForUserInterface();
        $provider = $this->userProvider;
        $manager  = $this->userManager;

        $manager
            ->expects($this->once())
            ->method('findUserByEmail')
            ->with($this->equalTo('user@example.com'))
            ->will($this->returnValue($user))
        ;
        $this->assertSame($user, $provider->loadUserByUsername('user@example.com'));
    }

}
 