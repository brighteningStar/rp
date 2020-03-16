<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $service;

    public function __construct(SearchService $searchService)
    {
        $this->service = $searchService;

    }

    public function searchByIMEI(Request $request)
    {
        $imei = $request->get('imei');
        $this->service->searchByIMEI($imei);

    }







}
