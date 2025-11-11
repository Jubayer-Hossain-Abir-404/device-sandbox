<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;

class LanguageController extends Controller
{
    public function list(Request $request)
    {
        return response()->json(['data' => 'test'], Res::HTTP_OK);
    }
}
