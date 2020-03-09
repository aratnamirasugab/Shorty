<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Link;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use App\Http\Services\LinkService;

class LinkController extends Controller
{

    public function __construct()
    {
        $this->service = new LinkService();
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
        if (!$request->url) {
            return response()->json([
                'error' => 'url is not present'
            ], 400); 
        }

        $shortcodeExist = DB::table('links')->where('shortcode', $request->shortcode)->first();
        if ($shortcodeExist != null) {
            return response()->json([
                'error' => 'The the desired shortcode is already in use.'
            ], 409);
        }
        
        $link = new Link;
        $link->url = $request->input('url');

        if ($request->shortcode) {
            $res = preg_match('/^[0-9a-zA-Z_]{6}$/', $request->shortcode);
            if($res == 0) {
                return response()->json([
                    'error' => 'The shortcode fails to meet the following regexp: ^[0-9a-zA-Z_]{4,}$.'
                ], 422);
            }
            $link->shortcode = $request->shortcode;
        } else {
            $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';   
            $randomChar = substr(str_shuffle($allowedChars), 0, 6);
            $link->shortcode = $randomChar;
        }

        $link->save();

        return response()->json([
            $link->shortcode
        ], 201);
    }

    public function showShortcode($code, Request $request)
    {
        $data = $this->service->something();
        dd($data);

        $shortcode = DB::table('links')->where('shortcode', $code)->first();        
        $urlRedirect = 'http://' . $shortcode->url;

        if (!$shortcode) {
            return response()->json([
                'error' => 'The shortcode cannot be found in the system'
            ], 404);
        }

        DB::table('links')->where('shortcode', $code)->increment('redirectCount', 1);

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
        $shortcode = DB::table('links')->where('shortcode', $code)->first();

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function fetchAShortcode(Request $request)
    {
        $shortcode = DB::table('links')->where('shortcode', $request->shortcode)->first();
        return response()->json((object)[
            'startDate' => $shortcode->created_at,
            'lastSeenDate' => $shortcode->updated_at,
            'redirectCount' => $shortcode->redirectCount
        ],200);
    }

}
