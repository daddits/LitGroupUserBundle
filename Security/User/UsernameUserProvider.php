<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Security\User;


/**
 * UsernameUserProvider.
 *
 * Loads user by username or email.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class UsernameUserProvider extends CoreUserProvider
{
    /**
     * @inheritDoc
     */
    protected function doLoadUserByUsername($username)
    {
        return $this->getUserManager()->findUserByUsernameOrEmail($username);
    }

} 