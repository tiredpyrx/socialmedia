<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_Files;
use App\Models\PostImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("front.post.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            "caption" => "required|string|max:250",
            "description" => "string|max:500",
            "files" => "max:4|required",
            "files.*" => "extensions:jpg,jpeg,png,webp,avif|image",
        ], [
            "caption.string" => "Post caption must be type of string",
            "description.string" => "Post description must be type of string",
            "files.required" => "Please upload atleast one image!",
            "files.max" => "Maximum 4 files can be uploaded per post!",
            "files.*.extensions" => "Post files must be type of: jpg, jpeg, png, webp, avif",
            "files.*.image" => "Post files must be an image"
        ]);


        if ($validator->fails()) {
            /** session değiştirerek kullanıcıya geribildirim göndermeyi çalış */
            return redirect()->back()->with("error", $validator->errors()->first());
        }

        $post = new Post();

        $post->fill([
            "caption" => $request->caption,
            "description" => $request->description,
            "user_id" => Auth::user()->id,
        ]);

        $post->save();

        if ($request->has("files")) {
            foreach ($request->file("files") as $file) {
                $post_image = new PostImage();
                $file_name = time() . rand(1, 10000) . $file->getClientOriginalName();
                $file_directory = "images/profiles/posts/" . Auth::user()->nick_name . "/";
                $file->move(public_path($file_directory), $file_name);
                $post_image->post_id = $post->id;
                $post_image->src = env('APP_URL') . $file_directory . $file_name;
                $post_image->save();
            }
        }


        // if ($request->hasFile("src")) {
        //     $file = $request->file("src");
        //     $fileName = $file->getClientOriginalName(); // file name and extension
        //     $file->move(public_path("images/posts/" . $user->nick_name), $fileName);
        //     $path = "images/posts/" . $user->nick_name . "/". $fileName;

        //     $post->src = $path;
        // }

        return redirect()->route("home")->with("succes", "Post Created Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            "caption" => "nullable|string|max:250",
            "description" => "nullable|max:500",
            "files" => "nullable|max:4",
            "files.*" => "nullable|extensions:jpg,jpeg,png,webp,avif|image",
        ], [
            "caption.string" => "Post caption must be type of string",
            "description.string" => "Post description must be type of string",
            "files.max" => "Maximum 4 files can be uploaded per post!",
            "files.*.extensions" => "Post files must be type of: jpg, jpeg, png, webp, avif",
            "files.*.image" => "Post files must be an image"
        ]);


        if ($validator->fails()) {
            /** session değiştirerek kullanıcıya geribildirim göndermeyi çalış */
            return redirect()->back()->with("error", $validator->errors()->first());
        }

        $filled_datas = array_filter($request->all());

        $post = Post::all()->find($id);

        $hide_likes = $request->has("hide_likes");

        if ($hide_likes) {
            $post->hide_likes = true;
        } else {
            $post->hide_likes = false;
        }

        $post->update($filled_datas);

        $post->save();

        $edited_images = collect($request->all())->filter(function ($val, $key) {
            if (str_starts_with($key, "file_")) {
                return true;
            }
        })->map(function ($val, $key) {
            return [
                substr($key, strpos($key, "_") + 1),
                $val
            ];
        });

        foreach ($edited_images->all() as $_ => $datas) {
            $file = $datas[1];
            $allowed_extensions = Post::ALLOWED_EXTENSIONS;
            $file_extension = $file->getClientOriginalExtension();
            if (!in_array($file_extension, $allowed_extensions)) {
                return redirect()->back()->with("error", "$datas[0] indexed input is type of $file_extension," . POST::EXTENSION_ERROR['plural']);
            }
            $file_name = time() . rand(1, 10000) . $datas[1]->getClientOriginalName();
            $file_directory = "images/profiles/posts/" . Auth::user()->nick_name . "/";
            $file->move(public_path($file_directory), $file_name);
            $post_image = PostImage::all()->find($datas[0]);
            File::delete(PostImage::all()->find($datas[0])->src);
            $post_image->src = env('APP_URL') . $file_directory . $file_name;
            $post_image->save();
        }

        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$id) return redirect()->back()->setStatusCode(404, "Post could not found!");
        Post::destroy($id);
        return redirect()->back()->setStatusCode(200, "Post deleted!");
    }
}
