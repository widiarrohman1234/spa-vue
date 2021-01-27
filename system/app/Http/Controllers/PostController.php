<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
//validasi RESTful API
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index()
    {
        //memanggil data dari tabel posts
        $posts = Post::all();

        //membuat respon JSON
        return response()->json([
            'success' => true,
            'message' => 'List data posts',
            'data' => $posts
        ], 200);


    }

    public function create(Request $request)
    {
        //

    }

    public function store(Request $request)
    {
                // membuat validasi form input
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
        ]);

        // memberikan respond error pada form input
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        // jika berhasil maka simpan ke database
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        //berjasil disimpan ke database
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $post
            ], 201);
        }

        //gagal simpan ke database
        return response()->json([
            'success' => false,
            'message' => 'Data gagal disimpan',
        ], 409);
    }

    public function show($id)
    {
        //mencari kiriman data berdasarkan id
        $post = Post::findOrfail($id);

        //membuat respon JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail data post',
            'data' => $post
        ], 200);
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //membuat validasi
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
        ]);

        //respond error validation
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        //menemukan id dari post
        $post = Post::findOrfail($post->id);

        if($post){
            //update post
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
                'data' => $post
            ], 200);
        }

        //jika data tidak berhasil
        return response()->json([
            'success' => false,
            'message' => 'Data gagal di update',
        ], 404);

    }

    public function destroy($id)
    {
        //mencari kiriman berdasarkan ID
        $post = Post::findOrfail($id);

        if($id){
            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di hapus',
            ], 200);
        }

        //jika data tidak berhasil di hapus
        return response()->json([
            'success' => false,
            'message' => 'Data gagal dihapus',
        ], 400);
    }
}
