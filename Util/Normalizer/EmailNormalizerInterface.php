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
 * EmailNormalizerInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface EmailNormalizerInterface
{
    /**
     * Normalizes email address.
     *
     * @param string $email
     *
     * @return string
     */
    public function normalizeEmail($email);
} 