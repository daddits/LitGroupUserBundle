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
use LitGroup\Bundle\UserBundle\Storage\UserStorageInterface;
use LitGroup\Bundle\UserBundle\Util\Normalizer\EmailNormalizerInterface;

/**
 * UserManager
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class UserManager implements UserManagerInterface
{
    /**
     * FQN of the user's class.
     *
     * @var string
     */
    private $userClass;

    /**
     * @var UserStorageInterface
     */
    private $storage;

    /**
     * @var EmailNormalizerInterface
     */
    private $emailNormalizer;


    /**
     * Constructor.
     *
     * @param UserStorageInterface     $storage         User's storage driver.
     * @param string                   $userClass       Full qualified user's class name.
     * @param EmailNormalizerInterface $emailNormalizer
     */
    public function __construct(UserStorageInterface $storage, $userClass, EmailNormalizerInterface $emailNormalizer)
    {
        $this->storage         = $storage;
        $this->userClass       = $userClass;
        $this->emailNormalizer = $emailNormalizer;
    }

    /**
     * @inheritDoc
     */
    public function getUserClass()
    {
        return $this->userClass;
    }

    /**
     * @inheritDoc
     */
    public function createUser()
    {
        $class = $this->getUserClass();

        return new $class;
    }

    /**
     * @inheritDoc
     */
    public function saveUser(UserInterface $user)
    {
        $this->updateCanonicalFields($user);
        $this->getStorage()->saveUser($user);
    }

    /**
     * @inheritDoc
     */
    public function deleteUser(UserInterface $user)
    {
        $this->getStorage()->deleteUser($user);
    }

    /**
     * @inheritDoc
     */
    public function findUserById($id)
    {
        return $this->getStorage()->findUserById($id);
    }

    /**
     * @inheritDoc
     */
    public function findUserByEmail($email)
    {
        $emailCanonical = $this->getEmailNormalizer()->normalizeEmail($email);

        return $this->findUserBy(['emailCanonical' => $emailCanonical]);
    }

    /**
     * @inheritDoc
     */
    public function findUserBy(array $criteria)
    {
        return $this->getStorage()->findUserBy($criteria);
    }

    /**
     * @inheritDoc
     */
    public function updateCanonicalFields(UserInterface $user)
    {
        $normalizer = $this->getEmailNormalizer();
        $user->setEmailCanonical($normalizer->normalizeEmail($user->getEmail()));
    }

    /**
     * Returns email normalizer.
     *
     * @return EmailNormalizerInterface
     */
    protected function getEmailNormalizer()
    {
        return $this->emailNormalizer;
    }

    /**
     * Return storage driver.
     *
     * @return UserStorageInterface
     */
    protected function getStorage()
    {
        return $this->storage;
    }

} 