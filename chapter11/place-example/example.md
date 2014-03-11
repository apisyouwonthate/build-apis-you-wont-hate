FORMAT: 1A
HOST: https://api.example.com

# FakeSquare API

This is documentation for the theoretical checkin app API that has been built througout the
book [Build APIs You Wont Hate](https://leanpub.com/build-apis-you-wont-hate).

## Authorization

This could be anything, but it seems like a good place to explain how access tokens work.

Most endpoints in the FakeSquare API will require the `Authorization` HTTP header.

```http
Authorization: Bearer vr5HmMkzlxKE70W1y4MibiJUusZwZC25NOVBEx3BD1
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

### Get places [GET]
Locate places close to a certain set of coordinates, or provide a box of coordinates to search within.

+ Parameters

    + lat (optional, number, `40.7641`) ... Latitude to search near, with any accuracy
    + lon (optional, number, `-73.9866`) ... Longitude to search near, with any accuracy
    + distance = `10` (optional, number, `20`) ... The radius size in miles to search for from lat and lon coordinates
    + box (optional, string, `40.7641,-73.9866,40.7243,-73.9841`) ... Top left latitude, top left longitude, bottom right latitude, bottom right longitude
    + number (optional, integer, `15`) ... The number of results to return per page
    + page = `1` (optional, integer, `15`) ... Which page of the result data to return


+ Response 200 (application/json)

        {
            "data": [
                {
                    "id": 2,
                    "name": "Videology",
                    "lat": 40.713857,
                    "lon": -73.961936,
                    "created_at": "2013-04-02"
                },
                {
                    "id": 1,
                    "name": "Barcade",
                    "lat": 40.712017,
                    "lon": -73.950995,
                    "created_at": "2012-09-23"
                }
            ]
        }

## Create new place [/places]

### Create a place [POST]

+ Request (application/json)

      + Body

            {
                "name": "Videology",
                "lat": 40.713857,
                "lon": -73.961936
            }

+ Response 201 (application/json)

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
+ Response 404 (application/json)

        {
          "error" : {
            "code" : "GEN-LIKETHEWIND",
            "http_code" : 404,
            "message" : "Resource Not Found"
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
+ Response 404 (application/json)

        {
          "error" : {
            "code" : "GEN-LIKETHEWIND",
            "http_code" : 404,
            "message" : "Resource Not Found"
          }
        }


## Place Images [/places/{id}/image]
Places can have an image associated with them, that will act as a cover photo or photograph.

+ Parameters

    + id (required, integer) ... The unqiue identifer of a place

### Set place image [PUT]
Assign a new image or replace the existing image for a place.

+ Request (image/gif)

    + Headers

            Authorization: Bearer {access token}
    + Body

            <raw source of gif file>

+ Request (image/jpeg)

    + Headers

            Authorization: Bearer {access token}
    + Body

            <raw source of jpeg file>

+ Request (image/png)

    + Headers

            Authorization: Bearer {access token}
    + Body

            <raw source of png file>

+ Response 201
+ Response 400 (application/json)

        {
          "error" : {
            "code": "GEN-FUBARGS",
            "http_code" : 400,
            "message": "Content-Type must be image/png, image/jpg or image/gif"
          }
        }


        {
          "error" : {
            "code" : "GEN-FUBARGS",
            "http_code" : 400,
            "message" : "No lat, lon or box provided."
          }
        }


        {
          "error" : {
            "code" : "GEN-FUBARGS",
            "http_code" : 400,
            "message" : "No image is provided in HTTP body."
          }
        }

+ Response 404 (application/json)

        {
          "error" : {
            "code" : "GEN-LIKETHEWIND",
            "http_code" : 404,
            "message" : "Resource Not Found"
          }
        }


### Delete place image [DELETE]
Remove the existing image for a place.

+ Request

    + Headers

            Authorization: Bearer {access token}

+ Response 200

+ Response 404 (application/json)

        {
          "error" : {
            "code" : "GEN-LIKETHEWIND",
            "http_code" : 404,
            "message" : "Resource Not Found"
          }
        }
