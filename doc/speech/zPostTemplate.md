<details>
 <summary><code>POST joomgallery/configs</code> <code><b>/</b></code> <code>(creates new configuration with data)</code></summary>

##### Parameters

> | name                  |  type     | data type    | description                                                           |
> |-----------------------|-----------|--------------|-----------------------------------------------------------------------|
> | all config parameters |  %     | Json, string |  | 


##### Responses

> | http code     | content-type                      | response                                                                                                                   |
> |---------------|-----------------------------------|----------------------------------------------------------------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`  | ```json {"type": "configs", "id": "2", "attributes": { "id": 1, "asset_id": 105, "title": "Global Configuration", ... }``` |

##### Example cURL

> ```shell
> curl -s --show-error  -X POST "http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs" -d "{\"asset_id\":234,\"title\":\"Global Configuration 2\",\"note\":\"\",\"group_id\":1,\"published\":1,\"ordering\":0,\"checked_out\":0, ...}"  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> POST http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token: 
> 
> {
>    "asset_id": 234,
>    "title": "Global Configuration 2",
>    "note": "",
>    "group_id": 1,
>    "published": 1,
>    ...
> }
> ```
</details>

