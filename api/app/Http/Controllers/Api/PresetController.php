<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresetRequest;
use App\Repositories\DeviceRepository;
use App\Services\PresetService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;

class PresetController extends Controller
{
    public function __construct(private PresetService $service, private DeviceRepository $repository)
    {
    }

    public function store(PresetRequest $request)
    {
        $res = $this->service->save($request);

        return response()->json([
            'message' => 'Preset saved successfully',
            'data' => $res->toArray(),
        ], Res::HTTP_CREATED);
    }

    public function list(Request $request)
    {
        return response()->json(['data' => $this->repository->getList($request->query->all())], Res::HTTP_OK);
    }
}
