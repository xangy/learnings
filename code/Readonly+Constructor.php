<?php

class Price {
    public readonly float $amt;
    public readonly string $currency;

    public function __construct(float $amt, string $currency)
    {
        $this->amt = $amt;
        $this->currency = $currency;
    }

    public function addAmount(float $add_amt): self
    {
        return new self(($this->amt + $add_amt), $this->currency);
    }

}

$price = new Price(10.0, 'USD');   // object assigned to $price.
$new_price = $price->addAmount(5.0); // older object is no longer being referenced by the variable, so gc will take care of removing it.



// Let's try to use this create rich domain models. with enums, immutable objects, contructor promotion, etc.

enum Currency: string
{
    case USD = 'US Dollar';
    case INR = 'Indian Rupee';
    case EUR = 'Euro';
}

enum OrderStatus
{
    case Pending;
    case Confirmed;
    case Shipped;
    case Cancelled;
}

readonly class Cost {
    public function __construct(
        public int $amt,
        public Currency $currency,
    ) {}
}

readonly class Order {
    public function __construct(
        public string $id,
        public Cost $cost,
        public OrderStatus $orderStatus = OrderStatus::Pending,
    ) {}

    public function markPaid(): self
    {
        return new self($this->id, $this->cost, OrderStatus::Confirmed);
    }
}


// Note the methods have not been completely thought of. But in generat, we were able to use enums to replace the strings used in the logic, we used readonly classes as we wanted the whole class to have immutable properties, we used `new self()` to return a new object instead of manipulating the existing object.

$product_cost = new Cost(50.0, Currency::USD);
$order = new Order('ACE123', $product_cost);
// Do some logic for payment, then
$confirmed_order = $order->markPaid();
