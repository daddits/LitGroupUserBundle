<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Tests\Util\Normalizer;


use LitGroup\Bundle\UserBundle\Util\Normalizer\CommonCaseNormalizer;

class CommonCaseNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return CommonCaseNormalizer
     */
    protected function getNormalizer()
    {
        return new CommonCaseNormalizer();
    }

    public function testInterfacesImplementation()
    {
        $normalizer = $this->getNormalizer();

        $this->assertInstanceOf('LitGroup\Bundle\UserBundle\Util\Normalizer\UsernameNormalizerInterface', $normalizer);
        $this->assertInstanceOf('LitGroup\Bundle\UserBundle\Util\Normalizer\EmailNormalizerInterface', $normalizer);
    }

    public function getUsernameNormalizationtests()
    {
        return [
            ['username', 'username'],
            ['UserName', 'username'],
            ['User_Name2', 'user_name2'],
            ['Имя Пользователя', 'имя пользователя'],
        ];
    }

    /**
     * @dataProvider getUsernameNormalizationTests
     */
    public function testUsernameNormalization($input, $expected)
    {
        $normalizer = $this->getNormalizer();
        $this->assertSame($expected, $normalizer->normalizeUsername($input));
    }

    public function getEmailNormalizationTests()
    {
        return [
            ['username@example.com', 'username@example.com'],
            ['UserName@Example.com', 'username@example.com'],
            ['User_Name2@example.com', 'user_name2@example.com'],
            ['Имя_Пользователя@Почта.рф', 'имя_пользователя@почта.рф'],
        ];
    }

    /**
     * @dataProvider getEmailNormalizationTests
     */
    public function testEmailNormalization($input, $expected)
    {
        $normalizer = $this->getNormalizer();
        $this->assertSame($expected, $normalizer->normalizeEmail($input));
    }
}
 