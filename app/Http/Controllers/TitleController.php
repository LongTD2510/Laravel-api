<?php

namespace App\Http\Controllers;

use App\Http\Services\TitleService;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    //
    protected $titleService;
    public function __construct(TitleService $titleService)
    {
        $this->titleService = $titleService;
        parent::__construct();
    }
    public function listTitle(Request $request)
    {
        $titles = $this->titleService->getTitle($request->all());
        return $this->responseSuccess($titles);
    }
}
