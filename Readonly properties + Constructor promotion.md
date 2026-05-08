---
topic: Foundation Reset - PHP 8.x + OOP Fundamentals
date: 07-05-2026
tags:
  - php
preparation-notes: "readonly on class properties creates immutable value objects. Constructor promotion: public function __construct(public readonly string $name). Combine with enums for rich domain models."
---
`readonly` in php can be applied on properties or class (if all properties are readonly). They are used to create immutable class properties. They can be initialized only once and further manipulation will throw error.

NOTE: `readonly` properties was introduced in PHP 8.1 and `readonly` classes was introduced in PHP 8.2

`readonly` can be used to create immutable objects and methods can be used to return new instances when an update is needed to the object.

Though the numbers of object used increases, it is taken care by PHP's garbage collector when no variable is referring to the old object.

```
class Price {
	public readonly float $amt;
	public readonly string $currency;
	
	public function __construct(float $amt, string $currency)
	{
		$this->amt = $amt;
		$this->currency = $currency;
	}

	public function addAmount(float $add_amt): Price
	{
		return new self(($this->amt + $add_amt), $this->currency);
	}  

}
```

Since all properties of the class is readonly, we can actually make the class readonly like the following:
```
readonly class Price {
	public float $amt;
	public string $currency;
	
	public function __construct(float $amt, string $currency)
	{
		$this->amt = $amt;
		$this->currency = $currency;
	}

	public function addAmount(float $add_amt): Price
	{
		return new self(($this->amt + $add_amt), $this->currency);
	}  

}
```

NOTE:
- `readonly` properties can't be initialized using object operator. e.g
```
class Example {
	public readonly string $value;
}

$example = new Example();
$example->value = 'test'; // will give error.
```
- `readonly` properties cannot have default value.
- `readonly` properties don't apply to properties on the object if the object variable is readonly.
- `readonly` properties can be reinitialized when cloned.

Contructor promotion is used to define and declare the properties when the class objects are created using the contructor. e.g

```
class Price {
	public function __construct(
		public readonly float $amt,
		public readonly string $currency,
	) {}
}

$price = new Price(10.0, 'INR');
```

In the above example, when an object of the class is created, the properties are defined and declared, this saves code space and assignment. We are creating an object of the price class, it has two properties: amount and the currency. The values are assigned to the properties as well.

Let's try to use this to create rich domain models.

Highlight on checking the feasibility of immutable objects and memory.

|                      | Mutable object   | Immutable object + new self()                                   |
| -------------------- | ---------------- | --------------------------------------------------------------- |
| Memory per execution | lower (in-place) | slightly high till garbage collector takes care of older object |
| Debugging            | Harder           | Trivial (nothing mutates)                                       |
| Concurrency safety   | Needs locking    | Free — nothing shares state                                     |
| Lifetime             | Often long-lived | Usually very short                                              |

## Related Topics
- https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.readonly-properties