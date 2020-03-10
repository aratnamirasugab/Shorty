<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class LinkRepository {

    public function searchShortcode($code)
    {
        return DB::table('links')->where('shortcode', $code)->first();
    }

    public function addRedirectCountByOne($code)
    {  
        return DB::table('links')->where('shortcode', $code)->increment('redirectCount', 1);
    }

    public function addNewShortcode($url, $randomChar)
    {
        return DB::table('links')->insert([
            'url' => $url, 
            'shortcode' => $randomChar
        ]);
    }

}