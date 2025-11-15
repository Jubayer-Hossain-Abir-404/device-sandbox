<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DeviceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;

class DeviceController extends Controller
{
    public function __construct(private DeviceRepository $repository)
    {
    }

    public function list(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->repository->getList($request->query->all())], Res::HTTP_OK);
    }
}
