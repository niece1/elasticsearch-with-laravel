<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
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
