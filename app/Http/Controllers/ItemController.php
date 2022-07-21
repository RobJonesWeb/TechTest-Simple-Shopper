<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Item;
use App\Models\Shop;
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

        $items = Item::query()->orderBy('shops_id')->orderBy('departments_id')->get();
        $departments = Department::all();
        $shops = Shop::all();

        return view('welcome', compact('items', 'departments', 'shops'));
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
            'name' => 'required',
            'qty' => 'required|gt:0',
            'shop' => 'required| gt:0',
        ]);

            $item = new Item();
            $item->name = $request->name ?? '';
            $item->qty = $request->qty ?? -1;
            $item->shops_id = $request->shop ?? -1;
            $item->departments_id = $request->department ?? '-1';
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
