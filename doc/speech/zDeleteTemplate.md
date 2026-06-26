<details>
 <summary><code>DELETE joomgallery/configs/:id</code> <code><b>/</b></code> <code>(deletes selected JG configuration set)</code></summary>

##### Parameters

> None

##### Responses

> None

##### Example cURL

> ```shell
> curl -s --show-error  -X DELETE "http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs/U2" -d "{\"configs\":\"4.3.1.2\",\"creationDate\":\"2026-01-01\"}"  -H "Content-Type: application/json" -H "X-Joomla-Token:  ..."
> ```

##### Example http

> ```http
> ###
> DELETE http://127.0.0.1/joomgallery5x_dev/api/index.php/v1/joomgallery/configs/2
> Accept: application/vnd.api+json
> Content-Type: application/json
> X-Joomla-Token: 
> ```
</details>

