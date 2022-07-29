<?php

namespace Curdal\AddressBook\Http\Controllers;

use Curdal\AddressBook\Http\Requests\PersonRequest;
use Curdal\AddressBook\Http\Resources\PersonResource;
use Curdal\AddressBook\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PeopleController extends Controller
{
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            return PersonResource::collection(
                Person::paginate($request->input('limit', 25))
            );
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function create(PersonRequest $request): JsonResponse|PersonResource
    {
        try {
            DB::beginTransaction();

            $person = (new Person())->create(
                $request->only(['first_name', 'last_name'])
            );

            $this->processContactInformation($person, $request);

            DB::commit();

            return new PersonResource($person);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function show(Person $person): JsonResponse|PersonResource
    {
        try {
            $person->load(['addresses', 'emails', 'phoneNumbers']);

            return new PersonResource($person);
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(PersonRequest $request, Person $person): JsonResponse|PersonResource
    {
        try {
            DB::beginTransaction();

            $person->update(
                $request->only(['first_name', 'last_name'])
            );

            // $this->processContactInformation($person, $request);

            DB::commit();

            return new PersonResource($person);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function destroy(Person $person): JsonResponse
    {
        try {
            DB::beginTransaction();

            $person->contactInformation()->delete();
            $person->delete();

            DB::commit();

            return response()->json([], 204);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    private function processContactInformation(Person $person, PersonRequest $request): void
    {
        if (! empty($emails = $request->input('emails'))) {
            foreach ($emails as $email) {
                $person->emails()->create([
                    'value' => $email,
                ]);
            }
        }

        if (! empty($phoneNumbers = $request->input('phone_numbers'))) {
            foreach ($phoneNumbers as $phoneNumber) {
                $person->phoneNumbers()->create([
                    'value' => $phoneNumber,
                ]);
            }
        }

        if (! empty($addresses = $request->input('addresses'))) {
            foreach ($addresses as $address) {
                $person->addresses()->create([
                    'value' => $address,
                ]);
            }
        }
    }
}
