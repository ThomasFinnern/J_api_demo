<details>
 <summary><code>PATCH joomgallery/configs/:id</code> <code><b>/</b></code> <code>(writes parameters into selecte cofigurtion sets</code></summary>

##### Parameters

> | name      |  type     | data type               | description                                                           |
> |-----------|-----------|-------------------------|-----------------------------------------------------------------------|
> | configs      |  %     | string   | like "4.4.0" or "4.3.0.1" | 
> | creationDate |  %     | string   | format "yyyy-mm-dd" example "2026-04-01"  |


##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json;charset=UTF-8`        | ```json { ... "configs": "4.3.1.2", "creationDate": "2026-01-01" }``` |

##### Example cURL

> ```shell
> curl -s --show-error  -X PATCH "http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/1/configs" -d "{\"\"jg_userspace\":1\"}"  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> PATCH http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token: 
> 
> {
>     "jg_userspace": 1,
> }
> ```
</details>

