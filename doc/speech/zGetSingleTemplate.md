<details>
 <summary><code>GET v1/joomgallery/configs/:id</code> <code><b>/</b></code> <code>(gets selected JG configuration set variables kept in JGs own table)</code></summary>

##### Parameters

> None

##### Responses

> | http code     | content-type                      | response                                                                                                                    |
> |---------------|-----------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`        | ```json {"type": "configs", "id": "1", "attributes": { "id": 1, "asset_id": 105, "title": "Global Configuration", ... }``` |

##### Example CURL

> ```batch
> curl -s --show-error  -X GET "http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs/1" -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> GET http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs/1
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token:  ...
> ```
</details>
