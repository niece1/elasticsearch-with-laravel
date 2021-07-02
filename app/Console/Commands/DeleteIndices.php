<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elasticsearch\Client;
use App\Models\Post;

class DeleteIndices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indices:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete elasticsearch indices';

    /**
     * Elasticsearch client instance.
     *
     * @var object
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @param Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @param \App\Models\Post $post
     * @return int
     */
    public function handle(Post $post)
    {
        $params = ['index' => $post->getSearchIndex()];

        if ($this->client->indices()->exists($params)) {
            $this->client->indices()->delete($params);
            $this->info('Indices deleted successfully!');
        }
    }
}
