<?php
/**
 * This file is part of the "LitGroupUserBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\UserBundle\Tests;

/**
 * TestCase
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockForUserInterface()
    {
        return $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Model\User\UserInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockForNamedUserInterface()
    {
        return $this->getMockForAbstractClass('LitGroup\Bundle\UserBundle\Model\User\NamedUserInterface');
    }
} 