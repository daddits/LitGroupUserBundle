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
 * NamedUser
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
abstract class NamedUser extends User implements NamedUserInterface
{
    /**
     * Username.
     *
     * @var string
     */
    protected $username;

    /**
     * Canonical username.
     *
     * @var string
     */
    protected $usernameCanonical;


    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function setUsernameCanonical($username)
    {
        $this->usernameCanonical = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->emailCanonical,
            $this->username,
            $this->usernameCanonical,
            $this->password,
            $this->salt
        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->emailCanonical,
            $this->username,
            $this->usernameCanonical,
            $this->password,
            $this->salt
            ) = unserialize($serialized);
    }
} 