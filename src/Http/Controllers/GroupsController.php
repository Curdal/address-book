<?php

namespace Curdal\AddressBook\Http\Controllers;

use Curdal\AddressBook\Http\Requests\GroupRequest;
use Curdal\AddressBook\Http\Resources\GroupResource;
use Curdal\AddressBook\Models\Group;
use Illuminate\Support\Facades\Request;

class GroupsController extends Controller
{
    public function create(GroupRequest $request)
    {
        $group = (new Group())->create(
            $request->only(['name', 'description'])
        );

        return new GroupResource($group);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->update(
            $request->only(['name', 'description'])
        );

        return new GroupResource($group);
    }

    public function delete(Group $group)
    {
        $group->delete();

        return response()->json([], 204);
    }
}
