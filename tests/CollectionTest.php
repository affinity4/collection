<?php
use PHPUnit\Framework\TestCase;
use Affinity4\Collection\Collection;

class CollectionTest extends TestCase
{
    private function getPrivateProperty(object $Class, $property)
    {
        if (is_object($Class)) {
            $ClassName = get_class($Class);
        }

        $ReflectionClass = new \ReflectionClass($ClassName);
        $ReflectionProperty = $ReflectionClass->getProperty($property);
        $ReflectionProperty->setAccessible(true);

        return $ReflectionProperty->getValue($Class);
    }

    public function testCollectionConstructorSetsPositionToZero()
    {
        $Collection = new Collection([
            'zero', 'one', 'two', 'three'
        ]);

        $this->assertEquals(0, $this->getPrivateProperty($Collection, 'position'));
    }

    /**
     * @depends testCollectionConstructorSetsPositionToZero
     */
    public function testsCollectionConstructorSetsCollectionAsEmptyArrayIfNoArgsPassed()
    {
        $Collection = new Collection();

        $this->assertTrue(is_array($this->getPrivateProperty($Collection, 'collection')));
        $this->assertCount(0, $this->getPrivateProperty($Collection, 'collection'));
    }

    public function testRewindSetsPositionToZero()
    {
        $Collection = new Collection([
            'zero', 'one', 'two', 'three'
        ]);
        
        $Collection->next();
        $this->assertEquals(1, $this->getPrivateProperty($Collection, 'position'));

        $Collection->rewind();
        $this->assertEquals(0, $this->getPrivateProperty($Collection, 'position'));
    }

    public function testCurrentGetsCurrentItemsValue()
    {
        $Collection = new Collection([
            'zero', 'one', 'two', 'three'
        ]);

        $this->assertEquals('zero', $Collection->current());

        $Collection->next();
        $this->assertEquals('one', $Collection->current());

        $Collection->next();
        $this->assertEquals('two', $Collection->current());

        $Collection->next();
        $this->assertEquals('three', $Collection->current());
    }

    public function testNextAndKey()
    {
        $Collection = new Collection([
            'zero', 'one', 'two', 'three'
        ]);

        $this->assertEquals(0, $Collection->key());

        $Collection->next();
        $this->assertEquals(1, $Collection->key());

        $Collection->next();
        $this->assertEquals(2, $Collection->key());
    }

    public function testNextPrevAndKey()
    {
        $Collection = new Collection([
            'zero', 'one', 'two', 'three'
        ]);

        $this->assertEquals(0, $Collection->key());

        $Collection->next();
        $this->assertEquals(1, $Collection->key());

        $Collection->next();
        $this->assertEquals(2, $Collection->key());

        $Collection->prev();
        $this->assertEquals(1, $Collection->key());

        $Collection->prev();
        $this->assertEquals(0, $Collection->key());
    }

    public function testValid()
    {
        $Collection = new Collection([
            'zero', 'one'
        ]);

        $this->assertEquals(0, $Collection->key());
        $this->assertTrue($Collection->valid());

        $Collection->next();
        $this->assertEquals(1, $Collection->key());
        $this->assertTrue($Collection->valid());
        

        $Collection->next();
        $this->assertEquals(2, $Collection->key());
        $this->assertFalse($Collection->valid());
    }

    public function testOffsetSetSetsArrayItemsOnCollection()
    {
        $CollectionA = new Collection();
        $CollectionA[] = 'zero';

        $this->assertEquals('zero', $CollectionA[0]);

        // Test overwrites when key exists
        $CollectionA[0] = 'one';
        $this->assertEquals('one', $CollectionA[0]);

        $CollectionA['one'] = 1;
        $this->assertEquals(1, $CollectionA['one']);

        $CollectionB = new Collection();
        $CollectionB->offsetSet(null, 'zero');

        $this->assertEquals('zero', $CollectionB->offsetGet(0));
        $this->assertEquals('zero', $CollectionB[0]);

        $CollectionB->offsetSet(0, 'one');
        $this->assertEquals('one', $CollectionB[0]);
        $this->assertEquals('one', $CollectionB->offsetGet(0));

        $CollectionB->offsetSet('one', 1);
        $this->assertEquals(1, $CollectionB['one']);
        $this->assertEquals(1, $CollectionB->offsetGet('one'));
    }

    public function testOffsetExists()
    {
        $Collection = new Collection();

        $Collection[] = 'zero';
        $this->assertTrue($Collection->offsetExists(0));
        $this->assertFalse($Collection->offsetExists(1));
    }

    public function testOffsetUnset()
    {
        $Collection = new Collection();

        $Collection[] = 'zero';
        $this->assertTrue($Collection->offsetExists(0));

        $Collection->offsetUnset(0);
        $this->assertFalse($Collection->offsetExists(0));
    }
}