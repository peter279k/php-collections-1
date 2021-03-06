<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit\Framework\TestCase;
use stdClass;
use Tebru\Collection\ArrayList;
use Tebru\Collection\HashMap;
use Tebru\Collection\HashSet;
use Tebru\Collection\MapEntry;
use Tebru\Collection\MapInterface;

/**
 * Class MapImplementationTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\AbstractMap
 * @covers \Tebru\Collection\HashMap
 * @covers \Tebru\Collection\MapEntry
 */
class MapTest extends TestCase
{
    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutAll(MapInterface $map)
    {
        $classKey = new stdClass();
        $hashMap = new HashMap();
        $hashMap->put($classKey, true);
        $hashMap->put('key', false);
        $map->putAll($hashMap);

        list($mapEntry1, $mapEntry2) = $map->entrySet()->toArray();

        self::assertInstanceOf(MapEntry::class, $mapEntry1);
        self::assertSame($classKey, $mapEntry1->key);
        self::assertTrue($mapEntry1->value);

        self::assertSame('key', $mapEntry2->key);
        self::assertFalse($mapEntry2->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutAllArray(MapInterface $map)
    {
        $map->putAllArray(['key' => 'value']);

        self::assertSame('value', $map->get('key'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testFind(MapInterface $map)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $map->put($object1, true);
        $map->put($object2, true);
        $map->put($object3, true);

        $mapEntry = $map->find(function (MapEntry $mapEntry) {
            return 2 === $mapEntry->key->foo;
        });

        self::assertSame($object2, $mapEntry->key);
        self::assertTrue($mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testFindFalse(MapInterface $map)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $map->put($object1, true);
        $map->put($object2, true);
        $map->put($object3, true);

        self::assertNull($map->find(function (MapEntry $mapEntry) {
            return 4 === $mapEntry->key->foo;
        }));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testExists(MapInterface $map)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $map->put($object1, true);
        $map->put($object2, true);
        $map->put($object3, true);

        self::assertTrue($map->exists(function (MapEntry $mapEntry) {
            return 2 === $mapEntry->key->foo;
        }));

        self::assertFalse($map->exists(function (MapEntry $mapEntry) {
            return 4 === $mapEntry->key->foo;
        }));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testClear(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->clear();

        self::assertCount(0, $map);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsKey(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertTrue($map->containsKey('key'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsKeyFalse(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertFalse($map->containsKey('key2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsValue(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertTrue($map->containsValue('value'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsValueFalse(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertFalse($map->containsValue('value2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testEntrySet(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        list($mapEntry, $mapEntry2) = $map->entrySet()->toArray();

        self::assertInstanceOf(MapEntry::class, $mapEntry);
        self::assertSame('key', $mapEntry->key);
        self::assertSame('value', $mapEntry->value);

        self::assertInstanceOf(MapEntry::class, $mapEntry2);
        self::assertSame('key2', $mapEntry2->key);
        self::assertSame('value2', $mapEntry2->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testEntrySetProvided(MapInterface $map)
    {
        $hashSet = new HashSet();
        $hashSet->add(1);
        $map->put('key', 'value');
        $mapEntry = $map->entrySet($hashSet)->toArray()[1];

        self::assertInstanceOf(MapEntry::class, $mapEntry);
        self::assertSame('key', $mapEntry->key);
        self::assertSame('value', $mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testGet(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertSame('value', $map->get('key'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testGetException(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertNull($map->get('key2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testIsEmpty(MapInterface $map)
    {
        self::assertTrue($map->isEmpty());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testIsEmptyFalse(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertFalse($map->isEmpty());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeySet(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertSame(['key'], $map->keySet()->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeySetProvided(MapInterface $map)
    {
        $hashSet = new HashSet();
        $hashSet->add(1);
        $map->put('key', 'value');

        self::assertSame([1, 'key'], $map->keySet($hashSet)->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutObject(MapInterface $map)
    {
        $class = new stdClass();
        $map->put($class, 'value');

        $mapEntry = $map->entrySet()->toArray()[0];

        self::assertSame($class, $mapEntry->key);
        self::assertSame('value', $mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutMultipleObject(MapInterface $map)
    {
        $class = new stdClass();
        $class2 = new stdClass();
        $map->put($class, 'value');

        self::assertCount(1, $map);
        self::assertNull($map->put($class2, 'value2'));
        self::assertCount(2, $map);
        self::assertSame('value', $map->put($class, 'value3'));
        self::assertCount(2, $map);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutArray(MapInterface $map)
    {
        $map->put([1], 'value');

        $mapEntry = $map->entrySet()->toArray()[0];

        self::assertSame([1], $mapEntry->key);
        self::assertSame('value', $mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutOverride(MapInterface $map)
    {
        $map->put('key', 'value');
        $oldValue = $map->put('key', 'value2');

        self::assertSame('value2', $map->get('key'));
        self::assertSame('value', $oldValue);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testRemove(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->remove('key');

        self::assertCount(0, $map);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testRemoveException(MapInterface $map)
    {
        $map->put('key', 'value');
        self::assertNull($map->remove('key2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeys(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame(['key', 'key2'], $map->keys()->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeysProvided(MapInterface $map)
    {
        $arrayList = new ArrayList();
        $arrayList->add(1);
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame([1, 'key', 'key2'], $map->keys($arrayList)->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testValues(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame(['value', 'value2'], $map->values()->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testValuesProvided(MapInterface $map)
    {
        $arrayList = new ArrayList();
        $arrayList->add(1);
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame([1, 'value', 'value2'], $map->values($arrayList)->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testFilter(MapInterface $map)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $map->put($object1, true);
        $map->put($object2, true);
        $map->put($object3, true);

        $result = $map->filter(function (MapEntry $mapEntry) {
            return 0 !== $mapEntry->key->foo % 2;
        });

        self::assertSame([$object1, $object3], $result->keys()->toArray());
    }

    public function getMaps()
    {
        return [
            [new HashMap()],
        ];
    }
}
