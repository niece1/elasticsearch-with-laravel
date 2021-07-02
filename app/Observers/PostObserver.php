<?php

namespace App\Observers;

use App\Models\Post;
use Elasticsearch\Client;
use App\Jobs\AddElasticsearchIndexJob;
use App\Jobs\DeleteElasticsearchIndexJob;

class PostObserver
{
    /**
     * Elasticsearch client instance.
     *
     * @var object
     */
    private $client;

    /**
     * Create a new Client instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        if ($post->published) {
            dispatch(new AddElasticsearchIndexJob($post));
        }
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        if ($post->published) {
            return dispatch(new AddElasticsearchIndexJob($post));
        }
        dispatch(new DeleteElasticsearchIndexJob($post));
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        if ($post->published) {
            dispatch(new DeleteElasticsearchIndexJob($post));
        }
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        if ($post->published) {
            dispatch(new AddElasticsearchIndexJob($post));
        }
    }
}
