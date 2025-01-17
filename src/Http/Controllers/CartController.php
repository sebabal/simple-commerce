<?php

namespace DoubleThreeDigital\SimpleCommerce\Http\Controllers;

use DoubleThreeDigital\SimpleCommerce\Exceptions\CustomerNotFound;
use DoubleThreeDigital\SimpleCommerce\Facades\Customer;
use DoubleThreeDigital\SimpleCommerce\Http\Requests\Cart\DestroyRequest;
use DoubleThreeDigital\SimpleCommerce\Http\Requests\Cart\IndexRequest;
use DoubleThreeDigital\SimpleCommerce\Http\Requests\Cart\UpdateRequest;
use DoubleThreeDigital\SimpleCommerce\SessionCart;
use Illuminate\Support\Arr;

class CartController extends BaseActionController
{
    use SessionCart;

    public function index(IndexRequest $request)
    {
        return $this
            ->getSessionCart()
            ->entry()
            ->data();
    }

    public function update(UpdateRequest $request)
    {
        $cart = $this->getSessionCart();
        $data = Arr::except($request->all(), ['_token', '_params', '_redirect']);

        foreach ($data as $key => $value) {
            if ($value === 'on') {
                $value = true;
            } elseif ($value === 'off') {
                $value = false;
            }

            $data[$key] = $value;
        }

        if (isset($data['name']) && isset($data['email'])) {
            $data['customer']['name'] = $data['name'];
            $data['customer']['email'] = $data['email'];

            unset($data['name']);
            unset($data['email']);
        }

        if (isset($data['customer'])) {
            try {
                $customer = Customer::findByEmail($data['customer']['email']);
            } catch (CustomerNotFound $e) {
                $customer = Customer::make()
                    ->data([
                        'name'  => isset($data['customer']['name']) ? $data['customer']['name'] : '',
                        'email' => $data['customer']['email'],
                    ])
                    ->save();
            }

            $customer->update($data['customer']);

            $cart->update([
                'customer' => $customer->id,
            ]);

            unset($data['customer']);
        }

        $cart
            ->update($data)
            ->calculateTotals();

        return $this->withSuccess($request);
    }

    public function destroy(DestroyRequest $request)
    {
        $this
            ->getSessionCart()
            ->update([
                'items' => [],
            ])
            ->calculateTotals();

        return $this->withSuccess($request);
    }
}
