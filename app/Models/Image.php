<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DeleteImage;

class Image extends Model
{
    use HasFactory;
    use DeleteImage;
    
    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Get original image path
     *
     * @return string
     */
    public function getOriginalPathAttribute()
    {
        return $this->getOriginal('path');
    }
}
