PHP Collections
===============
[![Build Status](https://travis-ci.org/tebru/php-collections.svg?branch=master)](https://travis-ci.org/tebru/php-collections)
[![Code Coverage](https://scrutinizer-ci.com/g/tebru/php-collections/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tebru/php-collections/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tebru/php-collections/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tebru/php-collections/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0be91355-28b0-4293-976f-5d27c9ce0c90/mini.png)](https://insight.sensiolabs.com/projects/0be91355-28b0-4293-976f-5d27c9ce0c90)

This library ports the Java Collections Framework to PHP.

Installation
------------

    composer require tebru/php-collections

Collections
-----------

Collections provide data storage where order and random access do not
matter.  All collections implement `CollectionInterface`.
  
### AbstractCollection

This is an abstract class that implements the methods it can.  It defers the
decision of what underlying data structure to use to the concrete implementation.

### Bag

This is an implementation of `CollectionInterface` that extends from
`AbstractCollection` and uses an array as data storage.

### AbstractList

This inherits from `AbstractCollection` and implements the `ListInterface`.
Lists add random access to collections.  The allow getting/setting/removing
at a specific index.  By default, they add elements to the end of the list.

### ArrayList

This is an implementation of `CollectionInterface` and `ListInterface`.
It extends from `AbstractList` and uses an array as data storage.

### AbstractSet

This extends from `AbstractCollection` and implements `SetInterface`. Sets
differ from generic collections by only allowing one of each element.

### HashSet

This is an implementation of `CollectionInterface` and `SetInterface` and
extends from `AbstractSet`.  This uses a `HashMap` as data storage.

Maps
----

Maps provide data storage where order does not matter, but the ability to
get a value by key is important.  All maps implement `MapInterface`.

### AbstractMap

This implements `MapInterface` and implements any methods that do not
need to know about the specific data storage.

### HashMap

This is an implementation of `MapInterface` and extends from
`AbstractMap`.  It uses an array as data storage.
