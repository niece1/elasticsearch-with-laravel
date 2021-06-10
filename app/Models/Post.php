<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * Get user record associated with specified post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get image associated with specified post
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    
    /**
     * Get category record associated with specified post
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get date in convenient for humans format
     *
     * @return string
     */
    public function getDateAttribute()
    {
        return is_null($this->updated_at) ? '' : $this->updated_at->diffForHumans();
    }
    
    /**
     * Get description
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->body ? substr(strip_tags(html_entity_decode($this->body)), 0, 85) : null;
    }
    
    /**
     * Add 3 dots at the end of description
     *
     * @return string
     */
    public function getThreeDotsAttribute()
    {
        return strlen(strip_tags(html_entity_decode($this->body))) > 85 ? " ..." : "";
    }
}
