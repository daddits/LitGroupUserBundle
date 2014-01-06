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
 * UserManagerInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface UserManagerInterface
{
    /**
     * Creates empty user instance.
     *
     * @return UserInterface
     */
    public function createUser();

    /**
     * Saves user in the storage.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function saveUser(UserInterface $user);

    /**
     * Deletes user from storage.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function deleteUser(UserInterface $user);

    /**
     * Finds user by ID.
     *
     * @param mixed $id
     *
     * @return UserInterface|null
     */
    public function findUserById($id);

    /**
     * Finds user by email.
     *
     * @param string $email
     *
     * @return UserInterface|null
     */
    public function findUserByEmail($email);

    /**
     * Finds user by criteria.
     *
     * @param array $criteria
     *
     * @return UserInterface|null
     */
    public function findUserBy(array $criteria);
} 