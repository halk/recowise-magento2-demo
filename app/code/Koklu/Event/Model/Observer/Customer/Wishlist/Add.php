<?php
namespace Koklu\Event\Model\Observer\Customer\Wishlist;

class Add extends \Koklu\Event\Model\Observer\Catalog\Product\Base
{
    const SUBJECT = 'added_to_wishlist';
}