<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Requests\updateCategory;
use App\Http\Services\CategoryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        parent::__construct();
    }

    public function listCategory(Request $request)
    {
        $category = $this->categoryService->getCategory($request->all());
        return $category;
    }

    public function updateCategory(Request $request)
    {
        try {
            $params    = $request->all();
            $validator = $this->validateUpdate($params);
            if ($validator->fails()) {
                return $this->responseError($validator->messages());
            }
            $res = $this->categoryService->updateCategory($params);
            if(!$res){
                return $this->responseError(__('messages.category_not_found'),446);
            }
            return $this->responseSuccess($res);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

    }

    public function validateUpdate($param)
    {
        $rule = [
            'category_id'   => 'required|integer',
            'category_name' => 'required',
        ];
        $message = [
            'category_id'   => 'Category id cannot be blank.',
            'category_name' => 'Category name cannot be blank.',
        ];
        return Validator::make($param, $rule, $message);
    }
}
