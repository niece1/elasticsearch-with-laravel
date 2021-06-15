<?php

namespace App\Repositories;

use App\Contracts\SearchRepositoryContract;
use App\Models\Post;

/**
 * Description of SqlSearchRepository
 *
 * @author Volodymyr Zhonchuk
 */
class SqlSearchRepository implements SearchRepositoryContract
{
    /**
     * Display a listing of Post resource by search criteria.
     *
     * @param  $keyword
     * @return \Illuminate\Http\Response
     */
    public function search($keyword)
    {
        return Post::query()
            ->with(['image', 'category'])
            ->where('published', 1)
            ->where('title', 'like', "%{$keyword}%")
            ->orWhere('body', 'like', "%$keyword%")
            ->limit(12)
            ->get();
    }
}
