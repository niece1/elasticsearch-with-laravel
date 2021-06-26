<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Post;

class PopularPostsComposer
{
    
     /**
      * Bind data to the view.
      *
      * @param \Illuminate\View\View $view
      * @return void
      */
    public function compose(View $view)
    {
        $view->with('popular_posts', Post::with(['image'])
                ->where('published', 1)
                ->orderBy('viewed', 'desc')
                ->limit(3)
                ->get());
    }
}
