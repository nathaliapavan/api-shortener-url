<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Url;
use App\Services\UrlService;
use Validator;

class UrlController extends Controller {

    protected $urlService;

    public function __construct(UrlService $urlService) {
        $this->urlService = $urlService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->urlService->getAll();
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json(Url::all());
    }

    public function show() {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->urlService->loadUrl(); // getById
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json(Url::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->all();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->urlService->buildUrl($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $result = ['status' => 201];

        try {
            $result['data'] = $this->urlService->deleteById($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function redirectUrl($code) {
        $result = ['status' => 200];

        try {
            $url = $this->urlService->getUrlByCode($code);
            $result['data'] = $url;
            return \Redirect::to($url);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }
    }
}
