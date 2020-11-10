PHP API server for WriteAway editor
========

License:
--------
MIT License (MIT). Please see [`LICENSE`](./LICENSE) for more information. Maintained by [Spiral Scout](https://spiralscout.com).


## API Endpoints:
### List Images
**GET** or **POST** `writeAway:images:list` to fetch a full list of available images.

Example response:
```json
{
  "status": 200,
  "data": [      
    {
      "id": "unique-id",
      "src": "image1.png"
    },
    {
      "id": "unique-id",
      "thumbnailSrc": "image2-th.png",
      "src": "image2.png"
    }
  ]
}
```
Possible image fields:
| Field | Type | Required | Description  |
| :--- | :--- | :--- | :--- |
| id | string | **Required** | Image id |
| src | string | **Required** | Image source URL |
| thumbnailSrc | string | Optional | Image thumbnail URL |
| height | number | Optional | Image height to display |
| width | number | Optional | Image width to display |

### Upload Image
**POST** `writeAway:images:upload` to upload an image file.

Example request:

`image` - FormData file

Example response: 
```json
{
  "status": 200,
  "data": [      
    {
      "id": "unique-id",
      "src": "image1.png"
    }
  ]
}
```
> For possible image fields see the previous endpoint.

### Delete Image
**POST** or **DELETE** `writeAway:images:delete` to delete a particular image

Example request:
```json
{
  "id": "unique-id"
}
```
Example response: 
```json
{
  "status": 200
}
```

### Get Piece
**GET** or **POST** `writeAway:pieces:get` to fetch a particular piece by its `id` and `type`.

Example request:
```json
{
  "id": "unique-id",
  "type": "piece-type"
}
```
> If no pieces found, a new one wil be created. `id` is a unique value across all pieces.

Example response:
```json
{
  "status": 200,
  "data": {
    "id": "unique-id",
    "type": "piece-type",
    "data": {
      "key": "value",
      "key...": "value..."
    }
  }
}
```
In case if validation errors the example response will be:
```json
{
  "status": 400,
  "errors": {
    "field-name": "error-message",
    "field-name...": "error-message..."
  }
}
```

### Save Piece
**POST** `writeAway:pieces:save` to save a particular piece by its `id` and `type`.

Example request:
```json
{
  "id": "unique-id",
  "type": "piece-type",
  "data": {
    "key": "value",
    "key...": "value..."
  }
}
```
> If no pieces found, a new one wil be created. `id` is a unique value across all pieces.

Example response:
```json
{
  "status": 200,
  "data": {
    "id": "unique-id",
    "type": "piece-type",
    "data": {
      "key": "value",
      "key...": "value..."
    }
  }
}
```
In case if validation errors the example response will be:
```json
{
  "status": 400,
  "errors": {
    "field-name": "error-message",
    "field-name...": "error-message..."
  }
}
``` 
