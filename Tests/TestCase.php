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

use ReflectionObject;

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

    /**
     * Set storage primary key for model.
     *
     * Models do not have setId() method.
     * Therefore ID value set through the reflection.
     *
     * @param object $model
     * @param $value
     *
     * @throws \LogicException
     */
    protected function setModelId($model, $value)
    {
        if (!is_object($model)) {
            throw new \LogicException('$model should be an object.');
        }
        $objectReflection = new ReflectionObject($model);
        if (!$objectReflection->hasProperty('id')) {
            throw new \LogicException(sprintf('Class object "%s" does not have an "id" property.', get_class($model)));
        }
        $propertyReflection = $objectReflection->getProperty('id');
        $propertyReflection->setAccessible(true);
        $propertyReflection->setValue($model, $value);
    }

} 