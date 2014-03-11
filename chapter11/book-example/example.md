FORMAT: 1A
HOST: https://api.example.com

# FakeSquare API

This is documentation for the theoretical checkin app API that has been built througout the
book [Build APIs You Wont Hate](https://leanpub.com/build-apis-you-wont-hate).

## Authorization

This could be anything, but it seems like a good place to explain how access tokens work.

Most endpoints in the FakeSquare API will require the `Authorization` HTTP header.

```http
Authorization: bearer 5262d64b892e8d4341000001
```

Failing to do so will cause the following error:

```json
{
  "error" : {
    "code" : "GEN-MAYBGTFO",
    "http_code" : 401,
    "message" : "Unauthorized"
  }
}
```

Or something. This is mostly just an introduction, so provide links to tutorial
sections elsewhere on your site.

# Group Places
Search and manage places.

## Place List [/places{?lat}{&lon}{&distance}{&box}{&number}{&page}]
Something

### Get places [GET]
Something else

+ Parameters

    + lat (optional, number, `40.7641`) ... Latitude to search near, with any accuracy
    + lon (optional, number, `-73.9866`) ... Longitude to search near, with any accuracy
    + distance = `10` (optional, number, `20`) ... The radius size to search for from lat and lon coordinates
    + box (optional, string, `40.7641,-73.9866,40.7243,-73.9841`) ... Top left latitude, top left longitude, bottom right latitude, bottom right longitude
    + number (optional, number, `15`) ... The number of results to return per page
    + page = `1` (optional, number, `15`) ... Which page of the result data to return


+ Response 200


## Create new place [/places]

### Create a place [POST]

+ Response 201

    + Headers

            Content-Type: application/json

    + Body

            {
                "data": [
                    "id": 2,
                    "name": "Videology",
                    "lat": 40.713857,
                    "lon": -73.961936,
                    "created_at": "2013-04-02"
                ]
            }



## Places [/places/{id}]
Manage an existing place.

+ Parameters

    + id (required, integer) ... The unqiue identifer of a place

### Get place [GET]

+ Response 200
+ Response 404

    + Headers

            Content-Type: application/json

    + Body

            {
              "error" : {
                "code": "GEN-LIKETHEWIND",
                "http_code" : 404,
                "message": "Resource Not Found"
              }
            }

### Modify place [PUT]

+ Request

    + Headers

            Authorization: Bearer {access token}

+ Response 200

### Delete place [DELETE]

+ Request

    + Headers

            Authorization: Bearer {access token}

+ Response 200
+ Response 404

    + Headers

            Content-Type: application/json

    + Body

            {
              "error" : {
                "code": "GEN-LIKETHEWIND",
                "http_code" : 404,
                "message": "Resource Not Found"
              }
            }


## Place Images [/places/{id}/image]
Places can have an image associated with them, that will act as a cover photo or photograph.

+ Parameters

    + id (required, integer) ... The unqiue identifer of a place

### Set place image [PUT]
Assign a new image or replace the existing image for a place.

+ Request (image/png)

    + Headers

            Authorization: Bearer {access token}
    + Body

            <raw source of png file>

+ Response 201
+ Response 404

    + Headers

            Content-Type: application/json

    + Body

            {
              "error" : {
                "code": "GEN-LIKETHEWIND",
                "http_code" : 404,
                "message": "Resource Not Found"
              }
            }


### Delete place image [DELETE]
Remove the existing image for a place.

+ Request

    + Headers

            Authorization: Bearer {access token}

+ Response 200
+ Response 400

    + Headers

            Content-Type: application/json

    + Body

            {
              "error" : {
                "code" : "GEN-FUBARGS",
                "http_code" : 400,
                "message" : "No lat, lon or box provided."
              }
            }

+ Response 404

    + Headers

            Content-Type: application/json

    + Body

            {
              "error" : {
                "code" : "GEN-LIKETHEWIND",
                "http_code" : 404,
                "message" : "Resource Not Found"
              }
            }
