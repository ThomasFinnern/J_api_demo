#### URL structure for Joomla API calls

Uniform Resource Locator structure abbreviated:

```url
www.example.com/documentation/index.html?p1=A&p2=B#ressource
\_____________/\_______________________/ \_______/ \_______/
       |                   |                 |         |
      host                path             query    fragment
```

Joomla API example: 
```url
example.com/api/index.php/v1/config/application?page[offset]=30&page[limit]=30
\__________/\____________/ \__________________/ \____________________________/ 
     |            |                 |                        |     
    host      api path         endpoints                    query
```
**path**: 
  * Start: `/api/index.php/` -> This tells that we address the webservice API.
  * API path: `v1/config/application` -> endpoints routes to address functionality

**query**:
  Segments after `?` separated by `&` used for pagination or filtering	
  
  * pagination: `page[offset]=30&page[limit]=30`
  * filter:     `filter[catid]=2&filter[state]=1`
  * sorting:    `list[ordering]=created&list[direction]=desc`
  * fields:     `fields[articles]=title,catid,state`

Special characters like '[', ']' must be converted like in other queries too.  
`http://127.0.0.1/api_6x/api/index.php/v1/config/application?page%5Boffset%5D=30&page%5Blimit%5D=30`
