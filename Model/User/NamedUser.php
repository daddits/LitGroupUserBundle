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
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $usernameCanonical;

    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsernameCanonical($username)
    {
        $this->usernameCanonical = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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