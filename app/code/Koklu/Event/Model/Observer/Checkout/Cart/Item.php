<?php
namespace Koklu\Event\Model\Observer\Checkout\Cart;

use Koklu\Event\Model\Observer\Catalog\Product\Base;

class Item extends Base
{
    const SUBJECT = 'added_to_cart';
}