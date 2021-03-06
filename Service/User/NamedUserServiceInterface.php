<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Service\User;

use LitGroup\Bundle\UserBundle\Model\User\NamedUserInterface;

/**
 * NamedUserServiceInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 *
 * @api
 */
interface NamedUserServiceInterface extends UserServiceInterface
{
    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return NamedUserInterface|null
     */
    public function findUserByUsername($username);

    /**
     * Finds user by username or email.
     *
     * @param string $usernameOrEmail
     *
     * @return NamedUserInterface|null
     */
    public function findUserByUsernameOrEmail($usernameOrEmail);
} 