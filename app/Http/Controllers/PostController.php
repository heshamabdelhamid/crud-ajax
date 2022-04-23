<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\imageTrait;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use imageTrait;
    public function index()
    {
        $posts = Post::paginate(PAFINATE_COUNT);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        // check photo exists
        $request_data = $request->except(['photo']);

        if ($request->photo) {

            $file_name = $this->saveImage($request->photo, 'images/posts');

            $request_data['photo'] = $file_name;
        }

        Post::create($request_data);

        return response()->json([
            'status' => true,
            'msg' => 'done'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::Find($id);

        if ($post) {
            return view('posts.edit', compact('post'));
        } else {
            return response()->json([
                'status' => false,
                'message' => 'هناك خطأ ما ',
            ]);
        }
    }

    public function update(UpdatePostRequest $request)
    {
        $post = Post::Find($request->post_id);

        if ($post) {
            $request_data = $request->except(['photo']);

            if ($request->photo) {
                $file_name = $this->saveImage($request->photo, 'images/posts');
                $request_data['photo'] = $file_name;
            }

            $post->update($request_data);
            return response()->json([
                'status' => true,
                'msg' => 'done'
            ]);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'هناك خطأ ما ',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // return $request;
        if ($request->photo) {
            Post::findOrFail($request->id)->delete('images/posts/' . $request->photo);
            return response()->json([
                'status' => true,
                'message' => 'تم الحذف بنجاح',
                'id' => $request->id
            ]);
        } else {
            Post::findOrFail($request->id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'تم الحذف بنجاح',
                'id' => $request->id
            ]);
        }
    }
}