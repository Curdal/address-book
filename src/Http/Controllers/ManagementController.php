<?php

namespace Curdal\AddressBook\Http\Controllers;

use Curdal\AddressBook\Models\Group;
use Curdal\AddressBook\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ManagementController extends Controller
{
    public function addGroups(Request $request, Person $person): JsonResponse
    {
        $this->validate($request, [
            'groups' => 'array',
            'groups.*' => 'numeric',
        ]);

        try {
            DB::beginTransaction();

            $person->groups()->attach($request->input('groups'));

            DB::commit();

            return response()->json(status: 200);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function removeGroups(Request $request, Person $person): JsonResponse
    {
        $this->validate($request, [
            'groups' => 'array',
            'groups.*' => 'numeric',
        ]);

        try {
            DB::beginTransaction();

            $person->groups()->detach($request->input('groups'));

            DB::commit();

            return response()->json(status: 200);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function addPeople(Request $request, Group $group): JsonResponse
    {
        $this->validate($request, [
            'people' => 'array',
            'people.*' => 'numeric',
        ]);

        try {
            DB::beginTransaction();

            $group->people()->attach($request->input('people'));

            DB::commit();

            return response()->json(status: 200);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function removePeople(Request $request, Group $group): JsonResponse
    {
        $this->validate($request, [
            'people' => 'array',
            'people.*' => 'numeric',
        ]);

        try {
            DB::beginTransaction();

            $group->people()->detach($request->input('people'));

            DB::commit();

            return response()->json(status: 200);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }
}
