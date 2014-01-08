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


use LitGroup\Bundle\UserBundle\Tests\TestCase;
use LitGroup\Bundle\UserBundle\Model\User\User;

class UserTest extends TestCase
{
    public function testId()
    {
        $user = $this->getUser();
        $this->assertNull($user->getId());

        $this->setModelId($user, 'some_id');
        $this->assertSame('some_id', $user->getId());
    }

    public function testEmail()
    {
        $user = $this->getUser();
        $this->assertNull($user->getEmail());

        $this->assertSame($user, $user->setEmail('user@example.com'));
        $this->assertSame('user@example.com', $user->getEmail());
    }

    public function testEmailCanonical()
    {
        $user = $this->getUser();
        $this->assertNull($user->getEmailCanonical());

        $this->assertSame($user, $user->setEmailCanonical('user@example.com'));
        $this->assertSame('user@example.com', $user->getEmailCanonical());
    }

    public function testUsername()
    {
        $user = $this->getUser();
        $this->assertNull($user->getUsername());

        // Username should has the same as an email.
        $user->setEmail('user@example.com');
        $this->assertSame('user@example.com', $user->getUsername());
    }

    public function testPlainPassword()
    {
        $user = $this->getUser();
        $this->assertNull($user->getPlainPassword());

        $this->assertSame($user, $user->setPlainPassword('password'));
        $this->assertSame('password', $user->getPlainPassword());
    }

    public function testPassword()
    {
        $user = $this->getUser();
        $this->assertNull($user->getPassword());

        $this->assertSame($user, $user->setPassword('password'));
        $this->assertSame('password', $user->getPassword());
    }

    public function testSalt()
    {
        $user = $this->getUser();
        $this->assertInternalType('string', $user->getSalt());
        $this->assertGreaterThan(0, strlen($user->getSalt()));
    }

    public function testEraseCredentials()
    {
        $user = $this->getUser();
        $user->setPlainPassword('password');

        $user->eraseCredentials();
        $this->assertNull($user->getPlainPassword());
    }

    public function testRoles()
    {
        $user  = $this->getUser();
        $roles = $user->getRoles();

        $this->assertInternalType('array', $roles);
        $this->assertEquals(['ROLE_USER'], $roles);
    }

    public function testSerialization()
    {
        $user = $this->getUser();
        $this->setModelId($user, 'some_id');
        $user
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
     * @return User
     */
    protected function getUser()
    {
        return $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Model\User\User');
    }
}
 