<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Reflection;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

require_once('Fixture/DummyClassWithGettersAndSetters.php');

/**
 * Testcase for Object Access
 *
 * @version $Id: ObjectAccessTest.php 3746 2010-01-21 20:29:02Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ObjectAccessTest extends \F3\Testing\BaseTestCase {

	protected $dummyObject;

	/**
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function setUp() {
		$this->dummyObject = new \F3\FLOW3\Tests\Reflection\Fixture\DummyClassWithGettersAndSetters();
		$this->dummyObject->setProperty('string1');
		$this->dummyObject->setAnotherProperty(42);
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getPropertyReturnsExpectedValueForGetterProperty() {
		$property = \F3\FLOW3\Reflection\ObjectAccess::getProperty($this->dummyObject, 'property');
		$this->assertEquals($property, 'string1');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getPropertyReturnsExpectedValueForPublicProperty() {
		$property = \F3\FLOW3\Reflection\ObjectAccess::getProperty($this->dummyObject, 'publicProperty2');
		$this->assertEquals($property, 42, 'A property of a given object was not returned correctly.');
	}

	/**
	 * @test
	 * @expectedException \RuntimeException
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getPropertyReturnsThrowsExceptionIfPropertyDoesNotExist() {
		\F3\FLOW3\Reflection\ObjectAccess::getProperty($this->dummyObject, 'notExistingProperty');
	}

	/**
	 * @test
	 * @expectedException \RuntimeException
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getPropertyReturnsThrowsExceptionIfArrayKeyDoesNotExist() {
		\F3\FLOW3\Reflection\ObjectAccess::getProperty(array(), 'notExistingProperty');
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getPropertyThrowsExceptionIfThePropertyNameIsNotAString() {
		$property = \F3\FLOW3\Reflection\ObjectAccess::getProperty($this->dummyObject, new \ArrayObject());
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function setPropertyThrowsExceptionIfThePropertyNameIsNotAString() {
		$property = \F3\FLOW3\Reflection\ObjectAccess::setProperty($this->dummyObject, new \ArrayObject(), 42);
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setPropertyReturnsFalseIfPropertyIsNotAccessible() {
		$this->assertFalse(\F3\FLOW3\Reflection\ObjectAccess::setProperty($this->dummyObject, 'protectedProperty', 42));
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function setPropertyCallsASetterMethodToSetThePropertyValueIfOneIsAvailable() {
		\F3\FLOW3\Reflection\ObjectAccess::setProperty($this->dummyObject, 'property', 4242);
		$this->assertEquals($this->dummyObject->getProperty(), 4242, 'setProperty does not work with setter.');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function setPropertyWorksWithPublicProperty() {
		\F3\FLOW3\Reflection\ObjectAccess::setProperty($this->dummyObject, 'publicProperty', 4242);
		$this->assertEquals($this->dummyObject->publicProperty, 4242, 'setProperty does not work with public property.');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function setPropertyCanDirectlySetValuesInAnArrayObject() {
		$arrayObject = new \ArrayObject();
		\F3\FLOW3\Reflection\ObjectAccess::setProperty($arrayObject, 'publicProperty', 4242);
		$this->assertEquals($arrayObject['publicProperty'], 4242, 'setProperty does not work with ArrayObject property.');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getPropertyCanAccessPropertiesOfAnArrayObject() {
		$arrayObject = new \ArrayObject(array('key' => 'value'));
		$expected = \F3\FLOW3\Reflection\ObjectAccess::getProperty($arrayObject, 'key');
		$this->assertEquals($expected, 'value', 'getProperty does not work with ArrayObject property.');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getPropertyCanAccessPropertiesOfAnArray() {
		$array = array('key' => 'value');
		$expected = \F3\FLOW3\Reflection\ObjectAccess::getProperty($array, 'key');
		$this->assertEquals($expected, 'value', 'getProperty does not work with Array property.');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getGettablePropertyNamesReturnsAllPropertiesWhichAreAvailable() {
		$gettablePropertyNames = \F3\FLOW3\Reflection\ObjectAccess::getGettablePropertyNames($this->dummyObject);
		$expectedPropertyNames = array('anotherProperty', 'property', 'property2', 'publicProperty', 'publicProperty2');
		$this->assertEquals($gettablePropertyNames, $expectedPropertyNames, 'getGettablePropertyNames returns not all gettable properties.');
	}

	/**
	 * @test
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getSettablePropertyNamesReturnsAllPropertiesWhichAreAvailable() {
		$settablePropertyNames = \F3\FLOW3\Reflection\ObjectAccess::getSettablePropertyNames($this->dummyObject);
		$expectedPropertyNames = array('anotherProperty', 'property', 'property2', 'publicProperty', 'publicProperty2', 'writeOnlyMagicProperty');
		$this->assertEquals($settablePropertyNames, $expectedPropertyNames, 'getSettablePropertyNames returns not all settable properties.');
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getGettablePropertiesReturnsTheCorrectValuesForAllProperties() {
		$allProperties = \F3\FLOW3\Reflection\ObjectAccess::getGettableProperties($this->dummyObject);
		$expectedProperties = array(
			'anotherProperty' => 42,
			'property' => 'string1',
			'property2' => NULL,
			'publicProperty' => NULL,
			'publicProperty2' => 42);
		$this->assertEquals($allProperties, $expectedProperties, 'expectedProperties did not return the right values for the properties.');
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function isPropertySettableTellsIfAPropertyCanBeSet() {
		$this->assertTrue(\F3\FLOW3\Reflection\ObjectAccess::isPropertySettable($this->dummyObject, 'writeOnlyMagicProperty'));
		$this->assertTrue(\F3\FLOW3\Reflection\ObjectAccess::isPropertySettable($this->dummyObject, 'publicProperty'));
		$this->assertTrue(\F3\FLOW3\Reflection\ObjectAccess::isPropertySettable($this->dummyObject, 'property'));

		$this->assertFalse(\F3\FLOW3\Reflection\ObjectAccess::isPropertySettable($this->dummyObject, 'privateProperty'));
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function isPropertyGettableTellsIfAPropertyCanBeRetrieved() {
		$this->assertTrue(\F3\FLOW3\Reflection\ObjectAccess::isPropertyGettable($this->dummyObject, 'publicProperty'));
		$this->assertTrue(\F3\FLOW3\Reflection\ObjectAccess::isPropertyGettable($this->dummyObject, 'property'));

		$this->assertFalse(\F3\FLOW3\Reflection\ObjectAccess::isPropertyGettable($this->dummyObject, 'privateProperty'));
		$this->assertFalse(\F3\FLOW3\Reflection\ObjectAccess::isPropertyGettable($this->dummyObject, 'writeOnlyMagicProperty'));
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function getPropertyPathCanRecursivelyGetPropertiesOfAnObject() {
		$alternativeObject = new \F3\FLOW3\Tests\Reflection\Fixture\DummyClassWithGettersAndSetters();
		$alternativeObject->setProperty('test');
		$this->dummyObject->setProperty2($alternativeObject);

		$expected = 'test';
		$actual = \F3\FLOW3\Reflection\ObjectAccess::getPropertyPath($this->dummyObject, 'property2.property');
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getPropertyPathReturnsNullForNonExistingPropertyPath() {
		$alternativeObject = new \F3\FLOW3\Tests\Reflection\Fixture\DummyClassWithGettersAndSetters();
		$alternativeObject->setProperty(new \stdClass());
		$this->dummyObject->setProperty2($alternativeObject);

		$this->assertNull(\F3\FLOW3\Reflection\ObjectAccess::getPropertyPath($this->dummyObject, 'property2.property.not.existing'));
	}

}
?>