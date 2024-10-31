<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $imageService;

    public function create(Request $request)
    {
        $categories = Category::all();
        $conditions = Condition::all();
        $brands = Brand::all();
        return view('item_create', [
            'categories' => $categories,
            'conditions' => $conditions,
            'brands' => $brands,
        ]);
    }

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function upload(Request $request)
    {
        $request->merge(['type' => 'items']);
        $this->imageService->saveImages($request);
        return redirect()->route('item.create');
    }

    public function store(ItemRequest $request)
    {
        Item::createWithDetails($request);
        return redirect('/');
    }
}
