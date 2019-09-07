<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;


class post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title', 'description', 'Content', 'image', 'published_at', 'category_id'
    ];

    /**
     * @return void
     */
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(tag::class);
    }
    public function hasTag($tagId)
    {
        return in_array($tagId,$this->tags->pluck('id')->toArray());
    }
}
