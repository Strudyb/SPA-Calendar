<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use http\Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\utils\Helpers\Helper;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Models\{Gallery, Post, Category};
use Illuminate\Support\Facades\Validator;

class ApiPostController extends ApiController
{

  public function __construct(Request $request)
  {
    $this->user = auth()->setRequest($request)->user();

  }



  public function index(Request $request)
  {


    if (!$this->user) {
      return $this->responseUnauthorized();
    }
    $pages = DB::table('posts')->where('status', 1)->where('type','page')->orderBy('created_at', 'desc')->get();
    $posts = Post::where('status', 1)
    ->where('type','post')
    ->orderBy('created_at', 'desc')
    ->get();

    $myPosts = Post::where('user_id',$this->user->id)->where('status', 1)->where('type','post')->orderBy('created_at', 'desc')->get();



    $categories = Category::orderBy('created_at', 'desc')->get();

    return [
      'pages' => $pages,
      'posts' => $posts,
      'myPosts' => $myPosts,
      'categories' => $categories
    ];
  }

  public function store(Request $request)
  {

    if (!$this->user) {
      return $this->responseUnauthorized();
    }

    $validator = Validator::make($request->all(), [
      'title' => 'required|string|max:155',
      'content' => 'string',
      'seo_title' => 'required|string|max:71',
      'seo_description' => 'required|string|max:160',
    ]);


    if ($validator->fails()) {
      return $this->responseUnprocessable($validator->errors());
    }


    $thumbnail = '';

    if ($request->thumbnail !== null) {
      $thumbnail = Helper::PostImageHelper(Str::slug($request->title), $request->thumbnail, $request->type);

    }

              $options = $request->options;



              $CreatePost = Post::create([
                  'title' => $request->title,
                  'content' => $request->input('content'),
                  'options' =>  json_encode($options),
                  'price' =>  $request->price,
                  'quantity' =>   $request->quantity,
                  'discounted_price' => $request->discounted_price,
                  'seo_title' => $request->seo_title,
                  'seo_description' => $request->seo_description,
                  'category_id' => $request->category_id,
                  'type' => $request->type,
                  'user_id' => $this->user->id,
                  'status' => $request->status,
                  'thumbnail' => $thumbnail
              ]);




      return response()->json($CreatePost);


  }

  public function update(Request $request, $id)
  {

    if (!$this->user) {
      return $this->responseUnauthorized();
    }

      $validator = Validator::make($request->all(), [
        'title' => 'max:155',
        'seo_title' => 'max:71',
        'seo_description' => 'max:160',
      ]);

    if ($validator->fails()) {
      return $this->responseUnprocessable($validator->errors());
    }

      $postData = Post::where('id', $id)->firstOrFail();

      if ($this->user->id === $postData->user_id || $this->user->role === 'admin') {
//
          $allFiles = $request->session()->get('userAdditionalFiles');
          $options = $request->options;
          $options['gallery'] = $allFiles;



          $thumbnail = $request->thumbnail == $postData->thumbnail ? $request->thumbnail : Helper::PostImageHelper(Str::slug($request->title), $request->thumbnail, 'post');

          $postData->title = $postData->title === request('title') ? $postData->title : request('title');
          $postData->content = $postData->content === $request->input('content') ? $postData->content : $request->input('content');
          $postData->seo_title = $postData->seo_title === request('seo_title') ? $postData->title : request('seo_title');
          $postData->price = $postData->price === request('price') ? $postData->price : request('price');
          $postData->discounted_price = $postData->discounted_price === request('discounted_price') ? $postData->discounted_price : request('discounted_price');
          $postData->quantity = $postData->quantity === request('quantity') ? $postData->quantity : request('quantity');
          $postData->seo_description = $postData->title === request('seo_description') ? $postData->title : request('seo_description');
          $postData->category_id = $postData->category_id === request('category_id') ? $postData->category_id : request('category_id');
          $postData->status = $postData->status === request('status') ? $postData->status : request('status');
          $postData->options = $postData->options === json_encode($options) ? $postData->options : json_encode($options);
          $postData->thumbnail = $thumbnail;
          $postData->save();


          $postData->save();
          $request->session()->forget('userAdditionalFiles');
          return response()->json($postData);

      }else{
          return $this->responseUnauthorized();
      }




  }

  public function show(Post $post, Request $request)
  {

    $collection = [
      'post' => $post,
      'user' => $this->user,
      'postComments' => $post->comments()
        ->where('approved', 1)
        ->orderBy('created_at', 'desc')
        ->get()
    ];
    return $collection;

  }

  public function destroy(Request $request, $id)
  {
    if (!$this->user) {
      return $this->responseUnauthorized();
    }
    $postData = Post::where('id', $id)->firstOrFail();

      if ($this->user->id === $postData->user_id || $this->user->role === 'admin') {
          try {
              $postData->delete();
              return response()->json($postData);

          } catch (Exception $e) {
              return $this->responseServerError('Error deleting resource.');
          }
      }else{
          return $this->responseUnauthorized();
      }


  }


  public function addCategory(Request $request)
  {

    if ($this->user->role !== 'admin') {
      return $this->responseUnauthorized();
    }

    //===========================================
    // ============ VALIDATION RULES ============
    //===========================================
    $validator = Validator::make($request->all(), [
      'title' => 'required|string|max:155',
      'seo_title' => 'required|string|max:71',
      'seo_description' => 'required|string|max:160',
    ]);
    if ($validator->fails()) {
      return $this->responseUnprocessable($validator->errors());
    }

    try {
      $category = Category::create([
        'title' => $request->title,
        'seo_title' => $request->seo_title,
        'seo_description' => $request->seo_description
      ]);
      return response()->json($category);

    } catch (\Exception $e) {
      return $this->responseServerError($e);
    }


  }

  public function updateCategory(Request $request)
  {

    if ($this->user->role !== 'admin') {
      return $this->responseUnauthorized();
    }



    $url = Helper::MakeUrl($request->title);
    $postData = Category::where('id', $request->id)->firstOrFail();

    try {


        $postData->title = $postData->title === request('title') ? $postData->title : request('title');
        $postData->parent_id = $postData->parent_id === request('parent_id') ? $postData->parent_id : request('parent_id');
        $postData->seo_title = $postData->seo_title === request('seo_title') ? $postData->seo_title : request('seo_title');
        $postData->seo_description = $postData->seo_description === request('seo_description') ? $postData->seo_description : request('seo_description');

        $postData->save();

        return response()->json($postData);

    } catch (\Exception $e) {
      return $this->responseServerError($e);
    }


  }

  public function removeCategory(Request $request)
  {

    if ($this->user->role !== 'admin') {
      return $this->responseUnauthorized();
    }
    $postData = Category::where('id', $request->id)->firstOrFail();

    try {
      $postData->delete();
      return response()->json([
        'status' => 201,
        'post_title' => $postData->title,
        'message' => 'Category Deleted.',
      ], 201);

    } catch (Exception $e) {
      return $this->responseServerError('Error deleting resource.');
    }
  }

  public function MyCases(Request $request)
  {

    $post = Post::where('user_id', $this->user->id)->where('expires_date', '>=', Carbon::today())->get();
    $categories = Category::orderBy('created_At', 'desc')->get();

    return [
      'posts' => $post,
      'categories' => $categories
    ];
  }


  public function uploadAdditionalFiles(Request $request)
  {
    if (!$this->user) {
      return $this->responseUnauthorized();
    }

    if (is_array($request->all())) {
      $allFiles = array();
      foreach ($request->file('files') as $image) {
        $FileFullName = $image->getClientOriginalName();
        $FileName = explode('.', $FileFullName)[0];
        $type = $image->extension();
        $FileNameForSaving = Str::slug($FileName).'.'.$type;
        $slug = '/uploads/'.$this->user->id.'/'.$FileNameForSaving;
        $image->move('uploads/'.$this->user->id, $FileNameForSaving);
        $Gallery = Gallery::firstOrCreate([
          'user_id' => $this->user->id,
          'file_name' => $FileName,
          'slug' => $slug,
          'type' => $type,
        ]);
        array_push($allFiles, $slug);
        session(['userAdditionalFiles' => $allFiles]);
        $Gallery->save();
      }



    }
    return response()->json([
      'status' => 201,
      'message' => 'Files Uploaded',
    ], 201);
  }


  public function uploadImageGallery(Request $request)
  {
    if (!$this->user) {
      return $this->responseUnauthorized();
    }


    if (is_array($request->all())) {
      $allFiles = array();
      foreach ($request->file('files') as $image) {
        $FileFullName = $image->getClientOriginalName();
        $FileName = explode('.', $FileFullName)[0];
        $type = $image->extension();
        $FileNameForSaving = md5(time()).'-'.Helper::MakeUrl($this->user->name).'.'.$type;
        $slug = '/uploads/'.$this->user->id.'/'.$FileNameForSaving;
        $image->move('uploads/'.$this->user->id, $FileNameForSaving);
        $Gallery = Gallery::firstOrCreate([
          'user_id' => $this->user->id,
          'file_name' => $FileName,
          'slug' => $slug,
          'type' => $type,
        ]);
        array_push($allFiles, $slug);
        session(['userAdditionalFiles' => $allFiles]);
        $Gallery->save();
      }



    }
    return response()->json([
      'status' => 201,
      'message' => 'Files Uploaded',
    ], 201);
  }





  public function removeProductGalleryImage(Request $request)
  {
    if (!$this->user) {
      return $this->responseUnauthorized();
    }

    $product = Post::find($request->id);
    $options = json_decode($product->options,true);
    $newoptions = [];
    $newoptions['features'] = $options['features'];
    $optionsGallery = $options['gallery'];
    $index = $request->index;
    unset($optionsGallery[$index]);
    $newoptions['gallery'] = $optionsGallery;

    $product->options = $newoptions;
    $product->save();


    return response()->json($product->options);
  }



}
