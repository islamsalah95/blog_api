<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Traits\ResponseTrait;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest; 

class TagController extends Controller
{
    use ResponseTrait; 


    public function index()
    {
        $tags = Tag::all();
        return self::success($tags, 'Tags retrieved successfully.');
    }


    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->validated());
        return self::success($tag, 'Tag created successfully.', 201);
    }


    public function show(Tag $tag)
    {
        return self::success($tag, 'Tag retrieved successfully.');
    }


    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update(["name"=>$request->name]);
        return self::success($tag, 'Tag updated successfully.');
    }


    public function destroy(Tag $tag)
    {
        $tag->delete();
        return self::success(null, 'Tag deleted successfully.', 204);
    }
}
