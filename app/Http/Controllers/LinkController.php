<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LinkRepository;
use Illuminate\Http\Request;
use App\Http\Services\LinkService;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{

    public function __construct()
    {
        $this->service = new LinkService();
        $this->repository = new LinkRepository();
    }

    public function store(Request $request)
    {
        $messages = [
            'url.required' => 'url is not present',
            'shortcode.regex' => 'The shortcode fails to meet the following regexp: ^[0-9a-zA-Z_]{6}$.'
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
            'shortcode' => $result['message']
        ], $result['status_code']);
    }

    public function showShortcode($code)
    {
        $urlRedirect = $this->service->addHttpUrl($code);

        if ($urlRedirect == '') {
            return response()->json([
                'error' => 'The shortcode cannot be found in the system'
            ], 404);
        }

        $this->repository->addRedirectCountByOne($code);
        $this->repository->updateUpdatedAt($code);

        return redirect($urlRedirect, 302);
    }
    
    public function showStats($code)
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
