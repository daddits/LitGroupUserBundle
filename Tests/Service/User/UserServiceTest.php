<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Tests\Service\User;

use LitGroup\Bundle\UserBundle\Service\User\UserService;
use LitGroup\Bundle\UserBundle\Storage\UserStorageInterface;
use LitGroup\Bundle\UserBundle\Tests\TestCase;
use LitGroup\Bundle\UserBundle\Util\Normalizer\EmailNormalizerInterface;

class UserServiceTest extends TestCase
{
    /**
     * @var UserService
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


    protected function setUp()
    {
        parent::setUp();
        $this->userClass       = $this->getMockClass('LitGroup\Bundle\UserBundle\Model\User\UserInterface');
        $this->userStorage     = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Storage\UserStorageInterface');
        $this->emailNormalizer = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Util\Normalizer\EmailNormalizerInterface');
        $this->userService = new UserService($this->userStorage, $this->userClass, $this->emailNormalizer);
    }

    protected function tearDown()
    {
        $this->userService     = null;
        $this->userClass       = null;
        $this->userStorage     = null;
        $this->emailNormalizer = null;
        parent::tearDown();
    }

    public function testGetUserClass()
    {
        $manager = $this->userService;
        $this->assertSame($this->userClass, $manager->getUserClass());
    }

    public function testCreateUser()
    {
        $manager = $this->userService;
        $this->assertInstanceOf($this->userClass, $manager->createUser());
    }

    public function testSaveUser()
    {
        $manager = $this
            ->getMockBuilder('LitGroup\Bundle\UserBundle\Service\User\UserService')
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->userStorage, $this->userClass, $this->emailNormalizer])
            ->setMethods(['updateCanonicalFields'])
            ->getMock()
        ;
        $storage = $this->userStorage;
        $user    = $this->getMockForUserInterface();

        $manager
            ->expects($this->once())
            ->method('updateCanonicalFields')
            ->with($this->identicalTo($user))
        ;
        $storage
            ->expects($this->once())
            ->method('saveUser')
            ->with($this->identicalTo($user))
        ;

        $manager->saveUser($user);
    }

    public function testDeleteUser()
    {
        $manager = $this->userService;
        $storage = $this->userStorage;
        $user    = $this->getMockForUserInterface();

        $storage
            ->expects($this->once())
            ->method('deleteUser')
            ->with($this->identicalTo($user))
        ;

        $manager->deleteUser($user);
    }

    public function testFindUserById()
    {
        $manager = $this->userService;
        $storage = $this->userStorage;
        $user    = $this->getMockForUserInterface();

        $storage
            ->expects($this->exactly(2))
            ->method('findUserById')
            ->with($this->equalTo('some_id'))
            ->will(
                $this->onConsecutiveCalls(
                    null,
                    $user
                )
            )
        ;

        $this->assertNull($manager->findUserById('some_id'));
        $this->assertSame($user, $manager->findUserById('some_id'));
    }

    public function testFindUserByEmail()
    {
        $manager    = $this->userService;
        $storage    = $this->userStorage;
        $user       = $this->getMockForUserInterface();
        $normalizer = $this->emailNormalizer;

        $normalizer
            ->expects($this->any())
            ->method('normalizeEmail')
            ->with($this->equalTo('email@example.com'))
            ->will($this->returnValue('normalized@example.com'))
        ;
        $storage
            ->expects($this->exactly(2))
            ->method('findUserBy')
            ->with($this->equalTo(['emailCanonical' => 'normalized@example.com']))
            ->will(
                $this->onConsecutiveCalls(
                    null,
                    $user
                )
            )
        ;

        $this->assertNull($manager->findUserByEmail('email@example.com'));
        $this->assertSame($user, $manager->findUserByEmail('email@example.com'));
    }

    public function testFindUserBy()
    {
        $manager  = $this->userService;
        $storage  = $this->userStorage;
        $user     = $this->getMockForUserInterface();
        $criteria = ['emailCanonical' => 'email@example.com'];

        $storage
            ->expects($this->exactly(2))
            ->method('findUserBy')
            ->with($this->equalTo($criteria))
            ->will(
                $this->onConsecutiveCalls(
                    null,
                    $user
                )
            )
        ;

        $this->assertNull($manager->findUserBy($criteria));
        $this->assertSame($user, $manager->findUserBy($criteria));
    }

    public function testUpdateCanonicalFields()
    {
        $manager         = $this->userService;
        $emailNormalizer = $this->emailNormalizer;
        $user            = $this->getMockForUserInterface();

        $user
            ->expects($this->any())
            ->method('getEmail')
            ->will($this->returnValue('email@example.com'))
        ;
        $emailNormalizer
            ->expects($this->once())
            ->method('normalizeEmail')
            ->with($this->equalTo('email@example.com'))
            ->will($this->returnValue('normalized@example.com'))
        ;
        $user
            ->expects($this->once())
            ->method('setEmailCanonical')
            ->with($this->equalTo('normalized@example.com'))
            ->will($this->returnSelf())
        ;

        $manager->updateCanonicalFields($user);
    }

}
 