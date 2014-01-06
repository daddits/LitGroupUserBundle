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
 * NamedUserInterface
 *
 * Interface provides username support for user.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 *
 * @api
 */
interface NamedUserInterface extends UserInterface
{
    /**
     * Sets username.
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username);
} 