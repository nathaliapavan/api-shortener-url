<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Url;
use Validator;

class UrlController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json(Url::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        try {
            $url = Url::findOrFail($id);
            $url->delete();

            return response()->json([
                'message' => 'Deleted Successfully.'
            ], 201);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Url not found.'
            ], 404);

        }
    }
}
