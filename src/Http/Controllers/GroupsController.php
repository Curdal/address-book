<?php

namespace Curdal\AddressBook\Http\Controllers;

use Curdal\AddressBook\Http\Requests\GroupRequest;
use Curdal\AddressBook\Http\Resources\GroupResource;
use Curdal\AddressBook\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class GroupsController extends Controller
{
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            return GroupResource::collection(
                Group::paginate($request->input('limit', 25))
            );
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function create(GroupRequest $request): JsonResponse|GroupResource
    {
        try {
            DB::beginTransaction();

            $group = (new Group())->create(
                $request->only(['name', 'description'])
            );

            DB::commit();

            return new GroupResource($group);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function show(Group $group): JsonResponse|GroupResource
    {
        try {
            $group->load(['people']);

            return new GroupResource($group);
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(GroupRequest $request, Group $group): JsonResponse|GroupResource
    {
        try {
            DB::beginTransaction();

            $group->update(
                $request->only(['name', 'description'])
            );

            DB::commit();

            return new GroupResource($group);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function destroy(Group $group): JsonResponse
    {
        try {
            DB::beginTransaction();

            $group->delete();

            DB::commit();

            return response()->json([], 204);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }
}
