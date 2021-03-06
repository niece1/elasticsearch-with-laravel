<?php

namespace App\Http\Controllers;

use App\Contracts\SearchRepositoryContract;

class SearchController extends Controller
{
    /**
     * SearchRepository instance.
     *
     * @var type object
     */
    private $searchRepository;

    /**
     * Create a new instance.
     *
     * @param  \App\Contracts\SearchRepositoryContract  $searchRepository
     * @return void
     */
    public function __construct(SearchRepositoryContract $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    /**
     * Display a listing of Post resource by search criteria.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $posts = $this->searchRepository->search(request('keyword'));
        return view('frontend.search', compact('posts'));
    }
}
