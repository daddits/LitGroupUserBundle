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

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use LitGroup\Bundle\UserBundle\Model\User\UserInterface;
use LitGroup\Bundle\UserBundle\Service\User\UserServiceInterface;

/**
 * CoreUserProvider.
 *
 * Abstract parent for security user providers.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
abstract class CoreUserProvider implements UserProviderInterface
{
    /**
     * User manager instance.
     *
     * @var UserServiceInterface
     */
    private $userService;


    /**
     * Constructor.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     *
     */
    public function loadUserByUsername($username)
    {
        $user = $this->doLoadUserByUsername($username);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Unable to find user identified by "%s"', $username));
        }

        return $user;
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     * @param SecurityUserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(SecurityUserInterface $user)
    {
        if (
            !$user instanceof UserInterface ||
            !$this->supportsClass(get_class($user))
        ) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->getUserService()->findUserById($user->getId());
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return boolean
     */
    public function supportsClass($class)
    {
        $supportedClass = $this->getUserService()->getUserClass();

        return $class === $supportedClass || is_subclass_of($class, $supportedClass);
    }

    /**
     * Returns User's Service.
     *
     * @return UserServiceInterface
     */
    protected function getUserService()
    {
        return $this->userService;
    }

    /**
     * Loads the user for the given username.
     *
     * Returns NULL if the user is not found.
     *
     * @param string $username
     *
     * @return UserInterface|null
     */
    abstract protected function doLoadUserByUsername($username);

}