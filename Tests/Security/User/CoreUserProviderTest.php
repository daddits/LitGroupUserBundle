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


use LitGroup\Bundle\UserBundle\Model\User\UserManagerInterface;
use LitGroup\Bundle\UserBundle\Security\User\CoreUserProvider;
use LitGroup\Bundle\UserBundle\Tests\TestCase;

class CoreUserProviderTest extends UserProviderTestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->userProvider =
            $this
                ->getMockBuilder('LitGroup\Bundle\UserBundle\Security\User\CoreUserProvider')
                ->enableOriginalConstructor()
                ->setConstructorArgs([$this->userManager])
                ->getMockForAbstractClass()
        ;
    }

    public function getSupportsClassTests()
    {
        return [
            // The same class:
            ['LitGroup\Bundle\UserBundle\Model\User\User', 'LitGroup\Bundle\UserBundle\Model\User\User', true],
            // Subclass:
            ['LitGroup\Bundle\UserBundle\Model\User\User', 'LitGroup\Bundle\UserBundle\Model\User\NamedUser', true],
            // Different class:
            ['LitGroup\Bundle\UserBundle\Model\User\User', 'DateTime', false],
        ];
    }

    /**
     * @dataProvider getSupportsClassTests
     */
    public function testSupportsClass($supportedClass, $class, $expected)
    {
        $this
            ->userManager
            ->expects($this->any())
            ->method('getUserClass')
            ->will($this->returnValue($supportedClass))
        ;
        $this->assertSame($expected, $this->userProvider->supportsClass($class));
    }


    public function testLoadUserByUserNameSuccess()
    {
        $user     = $this->getMockForUserInterface();
        $provider = $this->userProvider;
        $provider
            ->expects($this->once())
            ->method('doLoadUserByUsername')
            ->with($this->equalTo('Sharom'))
            ->will($this->returnValue($user))
        ;
        $this->assertSame($user, $provider->loadUserByUsername('Sharom'));
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testLoadUserByUsernameFailure()
    {
        $provider = $this->userProvider;
        $provider
            ->expects($this->once())
            ->method('doLoadUserByUsername')
            ->with($this->equalTo('Sharom'))
            ->will($this->returnValue(null))
        ;
        $provider->loadUserByUsername('Sharom');
    }


    public function testRefreshUserSuccess()
    {
        $manager  = $this->userManager;
        $provider = $this->userProvider;
        $user     = $this->getMockForUserInterface();

        $manager
            ->expects($this->any())
            ->method('getUserClass')
            ->will($this->returnValue(get_class($user)))
        ;
        $user
            ->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue('ID'))
        ;
        $manager
            ->expects($this->once())
            ->method('findUserById')
            ->with($this->equalTo('ID'))
            ->will($this->returnValue($user))
        ;

        $this->assertSame($user, $provider->refreshUser($user));
    }

    public function getRefreshUserFailureTests()
    {
        return [
            // Case 1: Unsupported class.
            [
                'stdClass',
                $this->getMockForUserInterface()
            ],

            // Case 2: User does not implement UserInterface, provided by the LitGroupUserBundle.
            [
                'Symfony\Component\Security\Core\User\UserInterface',
                $this->getMockForAbstractClass('Symfony\Component\Security\Core\User\UserInterface')
            ],
        ];
    }

    /**
     * @dataProvider getRefreshUserFailureTests
     * @expectedException \Symfony\Component\Security\Core\Exception\UnsupportedUserException
     */
    public function testRefreshUserFailure($supportedClass, $user)
    {
        $manager  = $this->userManager;
        $provider = $this->userProvider;

        $manager
            ->expects($this->any())
            ->method('getUserClass')
            ->will($this->returnValue($supportedClass))
        ;
        $manager
            ->expects($this->never())
            ->method('findUserById')
        ;

        $provider->refreshUser($user);
    }


}
 