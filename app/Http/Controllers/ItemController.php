<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {

        $items = Item::all();

        return view('welcome')->with('items', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:items',
            'qty' => 'required|gt:0'
        ]);

            $item = new Item();
            $item->name = $request->name;
            $item->qty = $request->qty;
            $item->save();
            return back()->with('message', "{$item->name} has been added to your shopping list")->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $item = Item::query()->findOrFail($id);
            $itemName = $item->name;
            $item->delete();
            return back()->with('message', "$itemName has successfully been deleted")->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }
}
