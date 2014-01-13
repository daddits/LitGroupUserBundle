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
 * CommonCaseNormalizer
 *
 * Common normalizer implementation for username and email.
 * It converts string to the lower case.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class CommonCaseNormalizer implements UsernameNormalizerInterface, EmailNormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalizeEmail($email)
    {
        return $this->normalize($email);
    }

    /**
     * @inheritDoc
     */
    public function normalizeUsername($username)
    {
        return $this->normalize($username);
    }

    /**
     * Converts string to the lower case.
     *
     * @param string $string Some string for normalization
     *
     * @return string Normalized String.
     */
    protected function normalize($string)
    {
        return (null === $string) ? null : mb_convert_case($string, MB_CASE_LOWER, mb_detect_encoding($string));
    }

} 