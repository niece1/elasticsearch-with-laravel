<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elasticsearch\Client;
use Exception;

/**
 * Command needs for flush() method from ElasticsearchEngine not make error, see flush() phpdoc.
 */
class CreateIndices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indices:create {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create elasticsearch index';

    /**
     * Elasticsearch client instance.
     *
     * @var object
     */
    protected $client;

    /**
     * Create a new command instance.
     *
     * @param Client $client
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = app('elasticsearch');
    }

    /**
     * Execute the console command.
     *
     * @param \App\Models\Post $post
     * @return int
     */
    public function handle()
    {
        if (!class_exists($model = $this->argument('model'))) {
            return $this->error("{$model} not found");
        }
        $model = new $model;
        try {
            $this->client->indices()->create([
                'index' => $model->searchableAs(),
                'body' => [
                    'settings' => [
                        'index' => [
                            'analysis' => [
                                'filter' => $this->filters(),
                                'analyzer' => $this->analyzers(),
                            ]
                        ]
                    ]
                ]
            ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    protected function filters()
    {
        return [
            'words_splitter' => [
                'catenate_all' => 'true',
                'type' => 'word_delimiter',
                'preserve_original' => 'true'
            ]
        ];
    }

    protected function analyzers()
    {
        return [
            'default' => [
                'filter' => ['lowercase', 'words_splitter'],
                'char_filter' => ['html_strip'],
                'type' => 'custom',
                'tokenizer' => 'standard'
            ]
        ];
    }
}
