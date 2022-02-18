<?php

namespace App;

use Laravel\Scout\Engines\Engine;
use Laravel\Scout\Builder;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;

class ElasticsearchEngine extends Engine
{
    /**
     * Elasticsearch client instance.
     *
     * @var object
     */
    protected $client;

    /**
     * Create a new engine instance.
     *
     * @param Client $client
     * @return void
     */
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
        return $this->defineSearch($builder, [
            'from' => ($page - 1) * $perPage,
            'size' => 10
        ]);
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed  $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
        return collect(Arr::get($results, 'hits.hits'))->pluck('_id')->values();
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
        //
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed  $results
     * @return int
     */
    public function getTotalCount($results)
    {
        return Arr::get($results, 'hits.total', 0);
    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function flush($model)
    {
        //If you use this command for the first time(on server for example) it may error,
        //because you need initial index
        $this->client->indices()->delete([
            'index' => $model->searchableAs()
        ]);
        //In Elasticsearch one should recreate index while flushing in (in contradistinction to Algolia)
        Artisan::call('indices:create', [
            'model' => get_class($model)
        ]);
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
        //
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

    /**
     * Define criteria to search.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  array  $options
     * @return mixed
     */
    protected function defineSearch(Builder $builder, array $options = [])
    {
        $params = array_merge_recursive($this->defineBodyRequest($builder->model), [
            'body' => [
                'from' => 0,
                'size' => 100,
                'query' => [
                    'multi_match' => [
                        'query' => $builder->query ?? '',
                        'fields' => $this->defineSearchableFields($builder->model),
                        'type' => 'phrase_prefix'
                    ]
                ]
            ]
        ], $options);
        return $this->client->search($params);
    }

    /**
     * Define search body.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array  $options
     * @return mixed
     */
    protected function defineBodyRequest($model, array $options = [])
    {
        return array_merge_recursive([
            'index' => $model->searchableAs(),
            'type' => $model->searchableAs(),
        ], $options);
    }

    /**
     * Define fields to search.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    protected function defineSearchableFields($model)
    {
        if (!method_exists($model, 'searchableFields')) {
            return [];
        }
        return $model->searchableFields();
    }
}
