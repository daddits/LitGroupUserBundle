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

use LitGroup\Bundle\UserBundle\Security\User\UsernameUserProvider;

class UsernameUserProviderTest extends UserProviderTestCase
{

    protected function setUp()
    {
        $this->userService  = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Service\User\NamedUserServiceInterface');
        $this->userProvider = new UsernameUserProvider($this->userService);
    }

    public function testLoadUserByUserName()
    {
        $user     = $this->getMockForUserInterface();
        $provider = $this->userProvider;
        $manager  = $this->userService;

        $manager
            ->expects($this->once())
            ->method('findUserByUsernameOrEmail')
            ->with($this->equalTo('user@example.com'))
            ->will($this->returnValue($user))
        ;
        $this->assertSame($user, $provider->loadUserByUsername('user@example.com'));
    }

}
 