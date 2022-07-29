# Address Book - API

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/curdal/address-book/run-tests?label=tests)](https://github.com/curdal/address-book/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/curdal/address-book/Check%20&%20fix%20styling?label=code%20style)](https://github.com/curdal/address-book/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)

This package was build for an assessment it allows for the management of your Address Book via Api calls.

## Installation

You can't install the package via composer so a manual install is required. Clone the repo and add the following to your composer.json

```json
"require": {
    // ...
    "curdal/address-book": "dev-main"
},
// ...
"repositories": [
    // ...
    {
        "type": "path",
        "url": "../address-book"
    }
],
```

**NOTE:** The `url` in the repositories array should point to where **you** cloned the repo.

Next you will need to run:

```bash
composer update
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="address-book-migrations"
php artisan migrate
```

**Note:** Package migrations will still run wether they are published or not

## Usage

The Api exposes the following endpoints for usage.

```bash
# Search/List endpoints
GET       api/address-book

# Groups endpoints
GET       api/address-book/groups
POST      api/address-book/groups
GET       api/address-book/groups/{group}
PUT       api/address-book/groups/{group}
DELETE    api/address-book/groups/{group}

## Group/People management endpoints
POST      api/address-book/groups/{group}/people
DELETE    api/address-book/groups/{group}/people

# People endpoints
GET       api/address-book/people
POST      api/address-book/people
GET       api/address-book/people/{person}
PUT       api/address-book/people/{person}
DELETE    api/address-book/people/{person}

## People/Groups management endpoints
POST      api/address-book/people/{person}/groups
DELETE    api/address-book/people/{person}/groups
```

## Example

Adding a group via POST request
```bash
POST http://127.0.0.1:8000/api/address-book/groups HTTP/1.1
content-type: application/json

{
    "name": "Sample G",
    "description": "Test Group"
}
```
Returns the following output
```json
{
    "data": {
        "id": 1,
        "name": "Sample G",
        "description": "Test Group",
        "people": []
    }
}
```

Adding a person via POST request
```bash
POST http://127.0.0.1:8000/api/address-book/people HTTP/1.1
content-type: application/json

{
    "first_name": "Bartholomew",
    "last_name": "Gingersnap",
    "emails": ["barth.gingersnap@example.com"]
}
```

Returns the following output

```json
{
    "data": {
        "id": 1,
        "first_name": "Bartholomew",
        "last_name": "Gingersnap",
        "addresses": [],
        "emails": [
            {
                "id":1,
                "value":"barth.gingersnap@example.com",
                "default":0
            }
        ],
        "phone_numbers": []
    }
}
```

Adding people to a group via POST *(Returns no output)*

```bash
POST http://127.0.0.1:8000/api/address-book/groups/1/people HTTP/1.1
content-type: application/json

{
    "people": [1]
}
```


## Testing

```bash
composer test
```

## Credits

- [Curtis Page](https://github.com/curdal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
