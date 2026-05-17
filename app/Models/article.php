<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

class article extends Model
{
    use  HasFactory;
    //مقادیری که کاربر میتونه پرش کنه
    protected $fillable = [
        	'title','slug',	'content',	'image','published_at'	
    ]; 
    //تبدیل خودکار نوع داده ها 
    protected $casts = [
        'view_count'   => 'integer',
        'is_published' => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'published_at' => 'datetime'
    ];
    //مقادیر پیشفرض
    protected $attributes = [
        'view_count'   => 0,
        'is_published' =>false
    ];
    //رابطه با جدول یوزر 
    public function user(){
        return  $this->belongsTo(User::class);
    }

    //اسکوپ محلی برای مقالات منتشر شده 
    public function scopePublished($query){
        return $query->where('is_published',true)
                    ->where('published_at','<=',now());
    }
    //صد و پنجاه کاراکتر اول هر مقاله رو جدا مکینه 
    public function getExcerptAttribute()
    {
        // اگر از حروف فارسی استفاده می‌کنید حتما از mb_substr استفاده کنید
        return mb_substr($this->content, 0, 150) . ". . .";
    }
    //متد افزایش تعداد بازدید
    public function incrementViewCount(){
        $this->increment('view_count');
    }
    //مقالات با اسلاگ صدا زده بشن 
    public function getRouteKeyName(){
        //return 'slug'; // route with slug
        return 'id';
    }

}
