<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LinkRepository;
use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\LinkService;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{

    public function __construct()
    {
        $this->service = new LinkService();
        $this->repository = new LinkRepository();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'url.required' => 'url is needed.',
            'shortcode.regex' => 'The shortcode fails to meet the following regexp: ^[0-9a-zA-Z_]{4,}$.'
        ];

        $validator = Validator::make($request->all(), [
            'url' => 'required|string',
            'shortcode' => 'sometimes|required|regex:/^[0-9a-zA-Z_]{6}$/',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }
        
        $result = $this->service->store($request->shortcode, $request->url);

        return response()->json([
            $result
        ], $result['status_code']);
    }

    public function showShortcode($code, Request $request)
    {
        $urlRedirect = $this->service->addHttpUrl($code);

        if (!$urlRedirect) {
            return response()->json([
                'error' => 'The shortcode cannot be found in the system'
            ], 404);
        }

        $this->service->incrementCounter($code);
        return redirect($urlRedirect, 302);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function showStats($code, Request $request)
    {
        $shortcode = $this->service->findShortcode($code);

        if (!$shortcode) {
            return response()->json([
                'error' => 'The shortcode cannot be found in the system'
            ], 404);
        }

        return response()->json((object) [
            'startDate' => $shortcode->created_at,
            'lastSeenDate' => $shortcode->updated_at,
            'redirectCount' => $shortcode->redirectCount
        ], 200);
        
    }

}
