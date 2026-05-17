<?php   

namespace App\Http\Controllers;

use App\Models\article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::published()->
        orderBy('published_at', 'desc')->
        paginate(10);
        return view('articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:articles,slug',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'published_at' => 'nullable|date'  ]);
        //اپلود عکس در صورت وجود
        if($request->hasFile("image"))
        {
            $validated["image"] = $request->file('image')->store('articles', 'public');
        }
        //ذخیره مقاله 
        $article = Article::create([
            'title'        => $validated['title'],
            'slug'         => $validated['slug'],
            'content'      => $validated['content'],
            'image'        => $validated['image'],
            'published_at' => $validated['published_at'],
            'user_id'      =>  Auth::id(),

            'view_count'   => 0,
            'is_published' => false
                     ]);
        //ریدایرکت به روت مقاله های من 
        return redirect()->route('articles.my_articles')->
        with('success', 'مقاله با موفقیت ویرایش شد و منتظر تایید ادمین است');


    }

    /**
     * Display the specified resource.
     */
    public function show(article $article)
    {
            $user = Auth::user();

        // بررسی اینکه اگر مقاله منتشر نشده است
        if ($article->is_published) {
            
            if (($user && ($user->id == $article->user_id || $user->isAdmin))) {
                 
                $article->incrementViewCount();
                 return view('articles.show', compact('article'));     
            }
            else abort("404 , error not found");
         
        }else abort("404 , error not created");
    
       


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(article $article)
    {
            
            $user = Auth::user();
            if (($user && ($user->id == $article->user_id || $user->isAdmin))) {
                 return view("articles.edit",compact("article"));  
            }
            else abort("403 , only writer or admin can edit ! ");   
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, article $article)
    {
       $user = Auth::user();
            if (!($user && ($user->id == $article->user_id || $user->isAdmin))) {
            
             abort("403 , only writer or admin can update ! ");
            }
                      $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:articles,slug'.$article->id,
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'published_at' => 'nullable|date'  ]);

        if($request->hasFile('image')){
            if($article->image){
                Storage::disk('public')->delete($article->image);
            }
            $validated["image"] = $request->file('image')->store('articles', 'public');
        }
        $article->fill($validated);
        if(!$user->isAdmin){
            $article->is_published=false;

        }
        $article->save();
        $message = "" ; 
        $route = "";
        if($user ->isAdmin){
            return redirect()->route('articles.show', $article)->with('success', 'مقاله با موفقیت ویرایش شد!');

        } 
        else
             return redirect()->route('articles.my_articles')->with('warning', 'مقاله  ویرایش شد ونیاز به تایید ادمین دارد !');
       

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(article $article)
    {
            $user = Auth::user();
            if (!($user && ($user->id == $article->user_id || $user->isAdmin))) {
            
             abort("403 , only writer or admin can delete ! ");
            }
           if($article->image){
                Storage::disk('public')->delete($article->image);
            }
           $article->delete();
           return redirect()->route('article.index')->with('success','article deleted !');

    }
    public function myarticles(){
        $user = Auth::user();

        $articles = Article::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('articles.my-articles', compact('articles'));
    }
}
