<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
