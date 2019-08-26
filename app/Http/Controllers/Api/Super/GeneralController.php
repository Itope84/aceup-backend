<?php

namespace App\Http\Controllers\Api\Super;

use Cloudder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function uploadImage(Request $request)
    {
        $url  = '';
        if ($request->file('image')) {
            $imageName = $request->file('image')->getRealPath();

            Cloudder::upload($imageName, null);

            list($width, $height) = getimagesize($imageName);

            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);

            $url = $image_url;
        }

        return response()->json(['data' => $url], 200);
    }
}
