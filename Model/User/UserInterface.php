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

use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

/**
 * UserInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 *
 * @api
 */
interface UserInterface extends SecurityUserInterface, \Serializable
{
    /**
     * Returns user's id in a storage.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Sets user's email.
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email);

    /**
     * Returns user's email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Sets encoded password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password);

    /**
     * Sets plain (non-encoded) password.
     *
     * @param string $plainPassword
     *
     * @return self
     */
    public function setPlainPassword($plainPassword);

    /**
     * Returns plain (non-encoded) password.
     *
     * @return string
     */
    public function getPlainPassword();
}