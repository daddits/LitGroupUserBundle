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
 * User
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
abstract class User implements UserInterface
{
    /**
     * Primary ID on storage.
     *
     * @var mixed
     */
    protected $id;

    /**
     * User's email.
     *
     * @var string
     */
    protected $email;

    /**
     * Canonical email.
     *
     * @var string
     */
    protected $emailCanonical;

    /**
     * Encrypted password.
     *
     * @var string
     */
    protected $password;

    /**
     * Salt for password encryption.
     *
     * @var string
     */
    protected $salt;

    /**
     * Plain password.
     *
     * Should not be mapped for storage.
     *
     * @var string
     */
    private $plainPassword;


    /**
     * Constructor.
     *
     * Do not forget call parent constructor from child class!
     */
    public function __construct()
    {
        $this->salt = sha1(uniqid(mt_rand(), true));
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function setEmailCanonical($email)
    {
        $this->emailCanonical = $email;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * @inheritDoc
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
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
            $this->password,
            $this->salt
        ) = unserialize($serialized);
    }

}