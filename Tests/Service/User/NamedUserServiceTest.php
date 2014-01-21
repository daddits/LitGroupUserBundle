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


use LitGroup\Bundle\UserBundle\Service\User\NamedUserService;
use LitGroup\Bundle\UserBundle\Storage\UserStorageInterface;
use LitGroup\Bundle\UserBundle\Tests\TestCase;
use LitGroup\Bundle\UserBundle\Util\Normalizer\EmailNormalizerInterface;
use LitGroup\Bundle\UserBundle\Util\Normalizer\UsernameNormalizerInterface;

class NamedUserServiceTest extends TestCase
{


    /**
     * @var NamedUserManager
     */
    protected $userService;

    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    /**
     * @var string
     */
    protected $userClass;

    /**
     * @var EmailNormalizerInterface
     */
    protected $emailNormalizer;

    /**
     * @var UsernameNormalizerInterface
     */
    protected $usernameNormalizer;


    protected function setUp()
    {
        parent::setUp();
        $this->userStorage
            = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Storage\UserStorageInterface');
        $this->userClass
            = $this->getMockClass('LitGroup\Bundle\UserBundle\Model\User\NamedUserInterface');
        $this->emailNormalizer
            = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Util\Normalizer\EmailNormalizerInterface');
        $this->usernameNormalizer
            = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Util\Normalizer\UsernameNormalizerInterface');
        $this->userService
            = new NamedUserService($this->userStorage, $this->userClass, $this->emailNormalizer, $this->usernameNormalizer);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->userStorage        = null;
        $this->userClass          = null;
        $this->emailNormalizer    = null;
        $this->usernameNormalizer = null;
        $this->userService        = null;
    }

    public function testUpdateCanonicalFields()
    {
        $manager            = $this->userService;
        $emailNormalizer    = $this->emailNormalizer;
        $usernameNormalizer = $this->usernameNormalizer;
        $user               = $this->getMockForNamedUserInterface();

        $user
            ->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('username'))
        ;
        $user
            ->expects($this->any())
            ->method('getEmail')
            ->will($this->returnValue('email@example.com'))
        ;
        $user
            ->expects($this->once())
            ->method('setUsernameCanonical')
            ->with($this->equalTo('canonical_username'))
            ->will($this->returnSelf())
        ;
        $user
            ->expects($this->once())
            ->method('setEmailCanonical')
            ->with($this->equalTo('canonical@example.com'))
        ;

        $usernameNormalizer
            ->expects($this->once())
            ->method('normalizeUsername')
            ->with($this->equalTo('username'))
            ->will($this->returnValue('canonical_username'))
        ;
        $emailNormalizer
            ->expects($this->once())
            ->method('normalizeEmail')
            ->with($this->equalTo('email@example.com'))
            ->will($this->returnValue('canonical@example.com'))
        ;

        $manager->updateCanonicalFields($user);
    }

    public function testFindUserByUsername()
    {
        $manager            = $this->userService;
        $storage            = $this->userStorage;
        $usernameNormalizer = $this->usernameNormalizer;
        $user               = $this->getMockForNamedUserInterface();

        $usernameNormalizer
            ->expects($this->exactly(2))
            ->method('normalizeUsername')
            ->with('username')
            ->will($this->returnValue('canonical_username'))
        ;
        $storage
            ->expects($this->exactly(2))
            ->method('findUserBy')
            ->with($this->equalTo(['usernameCanonical' => 'canonical_username']))
            ->will(
                $this->onConsecutiveCalls(
                    null,
                    $user
                )
            )
        ;

        $this->assertNull($manager->findUserByUsername('username'));
        $this->assertSame($user, $manager->findUserByUsername('username'));
    }

    public function testFindUserByUsernameOrEmailWithUsername()
    {
        $manager            = $this->userService;
        $storage            = $this->userStorage;
        $usernameNormalizer = $this->usernameNormalizer;
        $user               = $this->getMockForNamedUserInterface();

        $usernameNormalizer
            ->expects($this->exactly(2))
            ->method('normalizeUsername')
            ->with('username')
            ->will($this->returnValue('canonical_username'))
        ;
        $storage
            ->expects($this->exactly(2))
            ->method('findUserBy')
            ->with($this->equalTo(['usernameCanonical' => 'canonical_username']))
            ->will(
                $this->onConsecutiveCalls(
                    null,
                    $user
                )
            )
        ;

        $this->assertNull($manager->findUserByUsernameOrEmail('username'));
        $this->assertSame($user, $manager->findUserByUsernameOrEmail('username'));
    }

    public function testFindUserByUsernameOrEmailWithEmail()
    {
        $manager            = $this->userService;
        $storage            = $this->userStorage;
        $emailNormalizer    = $this->emailNormalizer;
        $user               = $this->getMockForNamedUserInterface();

        $emailNormalizer
            ->expects($this->exactly(2))
            ->method('normalizeEmail')
            ->with('email@example.com')
            ->will($this->returnValue('canonical@example.com'))
        ;
        $storage
            ->expects($this->exactly(2))
            ->method('findUserBy')
            ->with($this->equalTo(['emailCanonical' => 'canonical@example.com']))
            ->will(
                $this->onConsecutiveCalls(
                    null,
                    $user
                )
            )
        ;

        $this->assertNull($manager->findUserByUsernameOrEmail('email@example.com'));
        $this->assertSame($user, $manager->findUserByUsernameOrEmail('email@example.com'));
    }
}
 