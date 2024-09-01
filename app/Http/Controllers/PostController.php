<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostController extends Controller
{
    use ResponseTrait, SoftDeletes;


    public function index()
    {
        $user = auth('sanctum')->user();
        $posts = Post::with('tags')->where('user_id',$user->id)->orderBy('Pinned', 'desc')->get();
        
        return self::success($posts, 'Posts retrieved successfully.');
    }


    public function store(StorePostRequest $request)
    {
        $user = auth('sanctum')->user();

        $imagePath = $request->file('image')->store('image', 'public');

        $post = Post::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imagePath,
            'pinned' => $request->pinned,
        ]);

        $post->tags()->attach($request->tags);

        return self::success($post, 'Post created successfully.', 201);
    }


    public function show(Post $post)
    {
        $user = auth('sanctum')->user();

        if ($post->user_id !== $user->id) {
            return self::unauthorized();
        }

        return self::success($post, 'Post retrieved successfully.');
    }


    public function update(UpdatePostRequest $request, Post $post)
    {
        $user = auth('sanctum')->user();

        if ($post->user_id !== $user->id) {
            return self::unauthorized();
        }

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($post->cover_image);
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
            $post->cover_image = $imagePath;
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'Pinned' => $request->Pinned,
        ]);

        $post->tags()->sync($request->tags);

        return self::success($post, 'Post updated successfully.');
    }


    public function destroy(Post $post)
    {
        $user = auth('sanctum')->user();

        if ($post->user_id !== $user->id) {
            return self::unauthorized();
        }

        $post->delete();

        return self::success(null, 'Post deleted successfully.');
    }


    public function deleted()
    {
        $user = auth('sanctum')->user();
        $posts = Post::onlyTrashed()->where('user_id', $user->id)->get();

        return self::success($posts, 'Deleted posts retrieved successfully.');
    }


    public function restore($id)
    {
        $user = auth('sanctum')->user();
        $post = Post::withTrashed()->where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $post->restore();

        return self::success($post, 'Post restored successfully.');
    }

    public function count()
    {
        $posts = Post::count();
        return self::success($posts, 'Post count retrieved successfully.');
    }
}
