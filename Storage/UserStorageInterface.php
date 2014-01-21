<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Storage;

use LitGroup\Bundle\UserBundle\Model\User\UserInterface;

/**
 * UserStorageInterface
 *
 * User's model DAO interface.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface UserStorageInterface
{
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
     * @param integer $id
     *
     * @return UserInterface|null
     */
    public function findUserById($id);

    /**
     * Finds user by criteria.
     *
     * @param array $criteria
     *
     * @return UserInterface|null
     */
    public function findUserBy(array $criteria);

} 