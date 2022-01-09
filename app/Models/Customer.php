<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * Define fields to be searched on.
     *
     * @return array
     */
    public function toSearchArray()
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
    /**
     * Define table fields to be used in index on the whole.
     *
     * @return array
     */
    public function searchableFields()
    {
        return ['username'];
    }
}
