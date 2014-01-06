<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Model\User;

/**
 * NamedUserManagerInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface NamedUserManagerInterface
{
    /**
     * Finds user by username.
     *
     * @return NamedUserInterface|null
     */
    public function findUserByUsername();
} 