<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Link;
use Illuminate\Http\Request;

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
        
        $link = new Link;
        $link->url = $request->input('url');
        $link->shortcode = '';
        if (!$request->shortcode) {
            $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';   
            $randomChar = substr(str_shuffle($allowedChars), 0, 6);
            $res = preg_match('/^[0-9a-zA-Z_]{6}$/', $randomChar);
            
            while($res != 1) {
                $res = preg_match('/^[0-9a-zA-Z_]{6}$/', $randomChar);
            }

            $link->shortcode = $randomChar;
        } else {
            $link->shortcode = $request->shortcode;
        }

        $link->save();

        return response()->json([
            $link->url,
            $link->shortcode
        ]);
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
