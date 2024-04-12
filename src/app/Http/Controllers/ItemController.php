<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Category;
use App\Models\Content;
use App\Models\CategoryContent;
use App\Models\Condition;
use App\Models\Mylist;
use App\Models\Comment;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $items = Item::all();
        $mylists = Mylist::where('user_id', $user_id)->get();
        return view('index', compact('items', 'mylists'));
    }

    public function search(Request $request)
    {
        $user_id = Auth::id();
        $items = Item::KeywordSearch($request->keyword)->get();
        foreach($items as $item) {
            $mylists = Mylist::where('item_id', $item->id)->where('user_id', $user_id)->get();
        }
        return view('index', compact('items','mylists'));
    }

    public function detail(Request $request)
    {
        $item = Item::find($request->item_id);
        $category_content_id = CategoryContent::find($item->category_content_id);
        $category = Category::find($category_content_id->category_id);
        $content = Content::find($category_content_id->content_id);
        $mylists = Mylist::where('item_id', $request->item_id)->get();
        $comments = Comment::where('item_id', $request->item_id)->get();
        return view('detail', compact('item', 'category', 'content', 'mylists', 'comments'));
    }

    public function sellIndex()
    {
        $category_contents = CategoryContent::all();
        $conditions = Condition::all();
        return view('sell', compact('category_contents','conditions'));
    }

    public function store(ItemRequest $request)
    {
        $newItem = $request->only(['user_id', 'category_content_id', 'condition_id', 'name', 'explanation', 'price']);
        if(request('image')) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            if(app()->isLocal()) {
                $path = Storage::putFileAs('public', $file, $file_name);
                $newItem['image'] = Storage::url($path);
            } else {
                $path = Storage::disk('s3')->putFileAs('/', $file, $file_name, 'publick');
                $newItem['image'] = Storage::disk('s3')->url($path);
            }
        }
        Item::create($newItem);
        return redirect('/mypage');
    }
}
