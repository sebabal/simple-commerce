<?php

namespace DoubleThreeDigital\SimpleCommerce\Http\Controllers\Cp;

use DoubleThreeDigital\SimpleCommerce\Models\OrderStatus;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Stache\Stache;

class OrderStatusController extends CpController
{
    public function index()
    {
        if (! auth()->user()->hasPermission('edit settings') && auth()->user()->isSuper() != true) {
            abort(401);
        }

        return OrderStatus::all();
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasPermission('edit settings') && auth()->user()->isSuper() != true) {
            abort(401);
        }

        // TODO: use a validation request here

        $status = new OrderStatus();
        $status->uid = (new Stache())->generateId();
        $status->name = $request->name;
        $status->slug = $request->slug;
        $status->description = $request->description;
        $status->color = $request->color;
        $status->primary = false;
        $status->save();

        return $status;
    }

    public function update(OrderStatus $status, Request $request)
    {
        if (! auth()->user()->hasPermission('edit settings') && auth()->user()->isSuper() != true) {
            abort(401);
        }

        $status->name = $request->name;
        $status->slug = $request->slug;
        $status->description = $request->description;
        $status->color = $request->color;
        $status->primary = false;
        $status->save();

        return $status;
    }

    public function destroy(OrderStatus $status)
    {
        if (! auth()->user()->hasPermission('edit settings') && auth()->user()->isSuper() != true) {
            abort(401);
        }

        // TODO: make sure that the user cant delete the only remaining order status
        // TODO: do something with the orders that are currecntly using this status

        $status->delete();

        return redirect(route('settings.edit'))
            ->with('success', 'Deleted order status');
    }
}
