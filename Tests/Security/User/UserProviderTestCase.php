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

use LitGroup\Bundle\UserBundle\Tests\TestCase;
use LitGroup\Bundle\UserBundle\Service\User\UserServiceInterface;
use LitGroup\Bundle\UserBundle\Security\User\CoreUserProvider;

/**
 * UserProviderTestCase
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
abstract class UserProviderTestCase extends TestCase
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * @var CoreUserProvider
     */
    protected $userProvider;


    protected function setUp()
    {
        parent::setUp();
        $this->userService  = $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Service\User\UserServiceInterface');
    }

    protected function tearDown()
    {
        $this->userService  = null;
        $this->userProvider = null;
        parent::tearDown();
    }
} 