<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Tests\Model\User;

use LitGroup\Bundle\UserBundle\Model\User\NamedUser;
use LitGroup\Bundle\UserBundle\Tests\TestCase;

class NamedUserTest extends TestCase
{
    public function testUsername()
    {
        $user = $this->getUser();
        $this->assertNull($user->getUsername());

        $this->assertSame($user, $user->setUsername('sharom'));
        $this->assertSame('sharom', $user->getUsername());
    }

    public function testUsernameCanonical()
    {
        $user = $this->getUser();
        $this->assertNull($user->getUsernameCanonical());

        $this->assertSame($user, $user->setUsernameCanonical('sharom'));
        $this->assertSame('sharom', $user->getUsernameCanonical());
    }

    public function testSerialization()
    {
        $user = $this->getUser();
        $this->setModelId($user, 'some_id');
        $user
            ->setUsername('username')
            ->setUsernameCanonical('username_canonical')
            ->setEmail('email@example.com')
            ->setEmailCanonical('email_canonical@example.com')
            ->setPassword('password')
            ->setPlainPassword('plain password')
        ;

        $str = serialize($user);

        // Plain password should not be serialized:
        $user->setPlainPassword(null);
        $this->assertEquals($user, unserialize($str));
    }

    /**
     * @return NamedUser
     */
    protected function getUser()
    {
        return $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Model\User\NamedUser');
    }
}
 