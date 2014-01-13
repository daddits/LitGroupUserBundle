<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Util\Normalizer;

/**
 * UsernameNormalizerInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface UsernameNormalizerInterface
{
    /**
     * Normilizes a username.
     *
     * @param string $username
     *
     * @return string
     */
    public function normalizeUsername($username);
}