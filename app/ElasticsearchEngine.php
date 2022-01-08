<?php

namespace App;

use Laravel\Scout\Engines\Engine;
use Laravel\Scout\Builder;
use Elasticsearch\Client;
use Illuminate\Support\Arr;

class ElasticsearchEngine extends Engine
{
	protected $client;

	public function __construct(Client $client)
    {
    	$this->client = $client;
    }

    /**
     * Update the given model in the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $models
     * @return void
     */
    public function update($models)
    {
    	$models->each(function ($model) {
    		$params = $this->defineBodyRequest($model, [
    			'id' => $model->id,
    			'body' => $model->toSearchableArray(),
    		]);
    		$this->client->index($params);
    	});
    }

    /**
     * Remove the given model from the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $models
     * @return void
     */
    public function delete($models)
    {
        $models->each(function ($model) {
            $params = $this->defineBodyRequest($model, [
                'id' => $model->id,
            ]);
            $this->client->delete($params);
        });
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        return $this->defineSearch($builder);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  int  $perPage
     * @param  int  $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed  $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  mixed  $results
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function map(Builder $builder, $results, $model)
    {
        if (count($hits = Arr::get($results, 'hits.hits')) === 0) {
            return $model->newCollection();
        }
        return $model->getScoutModelsByIds(
            $builder,
            collect($hits)->pluck('_id')->values()->all()
        );
    }

    /**
     * Map the given results to instances of the given model via a lazy collection.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  mixed  $results
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Support\LazyCollection
     */
    public function lazyMap(Builder $builder, $results, $model)
    {
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed  $results
     * @return int
     */
    public function getTotalCount($results)
    {
    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function flush($model)
    {
    }

    /**
     * Create a search index.
     *
     * @param  string  $name
     * @param  array  $options
     * @return mixed
     */
    public function createIndex($name, array $options = [])
    {
    }

    /**
     * Delete a search index.
     *
     * @param  string  $name
     * @return mixed
     */
    public function deleteIndex($name)
    {
        //
    }

    protected function defineSearch(Builder $builder, array $options = [])
    {
        $params = array_merge_recursive($this->defineBodyRequest($builder->model), [
            'body' => [
                'from' => 0,
                'size' => 100,
                'query' => [
                    'multi_match' => [
                        'query' => $builder->query,
                        'fields' => ['name', 'username', 'email'],
                        'type' => 'phrase_prefix'
                    ]
                ]
            ]
        ], $options);
        return $this->client->search($params);
    }

    protected function defineBodyRequest($model, array $options = [])
    {
        return array_merge_recursive([
            'index' => $model->searchableAs(),
            'type' => $model->searchableAs(),
        ], $options);
    }
}
