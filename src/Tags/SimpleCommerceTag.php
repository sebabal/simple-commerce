<?php

namespace DoubleThreeDigital\SimpleCommerce\Tags;

use DoubleThreeDigital\SimpleCommerce\Countries;
use DoubleThreeDigital\SimpleCommerce\Currencies;
use Exception;
use Statamic\Tags\TagNotFoundException;
use Statamic\Tags\Tags;

class SimpleCommerceTag extends Tags
{
    protected static $handle = 'sc';
    protected static $aliases = ['simple-commerce'];

    protected $tagClasses = [
        'cart'     => CartTags::class,
        'checkout' => CheckoutTags::class,
        'coupon'   => CouponTags::class,
        'customer' => CustomerTags::class,
        'gateways' => GatewayTags::class,
        'shipping' => ShippingTags::class,
    ];

    public function wildcard(string $tag)
    {
        $tag = explode(':', $tag);

        $class = collect($this->tagClasses)
            ->map(function ($value, $key) {
                return [
                    'key'   => $key,
                    'value' => $value,
                ];
            })
            ->where('key', $tag[0])
            ->first()['value'];

        $method = isset($tag[1]) ? $tag[1] : 'index';

        try {
            return (new $class($this))->{$method}();
        } catch (Exception $e) {
            if (method_exists($class, 'wildcard')) {
                return (new $class($this))->wildcard($method);
            }

            throw new TagNotFoundException(__('simple-commerce::messages.tag_not_found', ['tag' => $tag[0]]));
        }
    }

    public function countries()
    {
        return Countries::toArray();
    }

    public function currencies()
    {
        return Currencies::toArray();
    }
}
