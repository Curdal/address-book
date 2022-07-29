<?php

namespace Curdal\AddressBook\Http\Controllers;

use Curdal\AddressBook\Models\Group;
use Curdal\AddressBook\Models\Person;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $people = Person::select('full_name AS display', 'people as type')
            ->when($request->input('search'), function ($query, $search) {
                return $query->where('display', 'like', "%{$search}%")
                    ->orWhereHas('emails', fn ($q) => $q->where('value', 'like', "%{$search}%"));
            });

        $groups = Group::select('name AS display', 'group as type')
            ->when($request->input('search'), function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->union($people)
            ->orderBy('display')
            ->paginate($request->input('limit', 25), $request->input('page'));

        return response()->json($groups);
    }
}
