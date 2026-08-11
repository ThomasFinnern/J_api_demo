---
aliases: assdfg
---

```mermaid
%%{init:{"theme":"forest"}, flowchart:{"curve": "linear"}}%%
%% linkStyle default interpolate basis
flowchart LR
start[API URL]  ~~~|" "| start --> plg[CRUD function] ~~~|" "| plg
```


```mermaid
%%{init:{"theme":"forest"}}%%
%% linkStyle default interpolate basis
flowchart LR

    subgraph userAPIroute["User API URL"]
		start("Post
			Get
			Patch
			<s>Put</s>
			Delete
		")
	end
	
    start --> plg

    subgraph WebServicePlugin["Web Service Plugin"]
		plg("CRUD function <br>(comp-controller)")
	end
	
        plg --> create
        plg --> read 
        plg --> update 
        plg --> delete 

    subgraph ApiPluginSupport["J! API Plugin support"]
        create("Create")
        read("Read")
        update("Update")
        delete("Delete")
	end
	
        create --> apiComp
        read --> apiComp
        update --> apiComp
        delete --> apiComp

    subgraph ApiComponentController["Api component"]
        
        apiComp["controller, model, view <br> or empty"]

    end

    subgraph CRUD_Operations["J! API functions"]
	
        apiComp --> apiJoomla

    end


    apiJoomla["API Joomla"]	-->
	modelComponent["Model of Component"] -->
	tableComponent["Table of Component"] 

```









----

```mermaid
graph TD
  %% Set edges to be curved (try monotoneX for a nice alternative)
  linkStyle default interpolate basis
  A[Christmas] -->|Get money| B(Go shopping)
  B --> C{Let me think}
  C -->|One| D[Laptop]
  C -->|Two| E[iPhone]
  C -->|Three| F[fa:fa-car Car]
```



```



```mermaid
sequenceDiagram
    Client->>+Server: Request
    Server-->>Session Store: Create new session
    Server->>+Client: Response + Cookie
    Note over Client,Server: Cookie includes session information
    Client->>+Server: Request + Cookie
    Server-->>Session Store: Request session data
    Session Store-->>Server: Session data
```

```mermaid
sequenceDiagram
Joomla->>service provider:get extension
service provider->>Extension:new
service provider->>Joomla:return extension
Joomla->>Extension:getDispatcher()
Extension->>Dispatcher:new
Extension->>Joomla:return dispatcher
Joomla->>Dispatcher:dispatch()
```


```mermaid
sequenceDiagram
    Code->Dispatcher: Get Dispatcher <br>$dispatcher
    Code->>PluginHelper: PluginHelper::importPlugin($type, null, true, $dispatcher)
    PluginHelper-->>Plugins Table: Query all active
    Note over PluginHelper, Plugins Table: Only once at runtime, and <br>result is cached in memory
    Plugins Table-->>PluginHelper: Return all active
    PluginHelper-->>Dispatcher: Import only <br>group of $type <br>(once at runtime)
    PluginHelper->>Plugin: Execute each plugin's service/provider.php
    Dispatcher->>Plugin: Call $plugin->getSubscribedEvents() <br>for each plugin in group
    Plugin->>Dispatcher: Return list of listeners
    Code->>Dispatcher: dispatch('onFooBar', <br>$eventObject)
    Dispatcher->>Plugin: Call listener for onFooBar event
    Note over Plugin: Plugin executes own logic <br>and, when event support this, <br>add result to $eventObject
```

---
```mermaid
sequenceDiagram
Joomla->>ConsolePlugin:instantiate plugin
Joomla->>ConsolePlugin:getSubscribedEvents()
ConsolePlugin->>Joomla:return method for ApplicationEvents::BEFORE_EXECUTE
Joomla->>ConsolePlugin:ApplicationEvents::BEFORE_EXECUTE event
ConsolePlugin->>Command:instantiate Command class
ConsolePlugin->>Joomla:calls addCommand(), passing the Command instance
Joomla->>Command:configure()
Command->>Joomla:return description and help text
Joomla->>Command:doExecute()
Note over Command:Command runs the code to <br>execute the required operation
Command->>Joomla:return exit code
```



```mermaid
sequenceDiagram
actor User
User->>media-manager.js:delete file
media-manager.js->>com_media:Ajax HTTP DELETE
com_media->>Provider Manager:Instantiate
com_media->>Plugins:import filesystem plugins
Plugins->>Provider Plugin:instantiate plugin
com_media->>Plugins:Trigger onSetupProviders
Plugins->>Provider Plugin:onSetupProviders()
Provider Plugin->>Provider Manager:registerProvider()
com_media->>Provider Manager:getAdapter()
Provider Manager->>Provider Plugin:getAdapters
Provider Plugin->>Provider Adapter:instantiate Adapter
Provider Plugin->>Provider Manager:return Adapters
Provider Manager->>com_media:return Adapter
com_media->>Provider Adapter:getFile()
Note over com_media, Provider Adapter: to check the file exists
Provider Adapter->>com_media:return file details
com_media->>Plugins:Trigger onContentBeforeDelete
com_media->>Provider Adapter:delete()
com_media->>Plugins:Trigger onContentAfterDelete
com_media->>media-manager.js:confirm delete
media-manager.js->>User:remove file from display
```

```mermaid
---
"title": "Path URL request to used model"
---
%%{init:{
    "theme":"forest",
    "flowchart" : {"curve" : "linear"}
    }
}%%

%% linkStyle default interpolate basis

flowchart LR

    classDef hidden display: none;

    urlRequest("Url request")

    subgraph compApiController["API component controller"]
        comp_api_controller("Request ()")
        comp_api_no_controller("<s>Request</s>")
    end

    subgraph joomlaApiController["Joomla API controller"]
        joomla_api_controller("Request ()")
    end

    subgraph compApiModel["API component model"]
        comp_api_model("functions ()")
        comp_api_no_model("<s>functions ()</s>")
    end

    subgraph compAdminModel["Admin component model"]
        comp_admin_model("functions ()")
    end


    urlRequest --> comp_api_controller
    urlRequest -.-> comp_api_no_controller -.-> joomla_api_controller 
%%    urlRequest -.-> joomla_api_controller 
    
    %% comp_api_controller --> joomla_api_controller
    joomla_api_controller --> comp_api_model
    joomla_api_controller -.-> comp_api_no_model -.-> comp_admin_model

%%    compApiController --- compApiModel
```
????

```mermaid
%%{init:{
    "theme":"forest",
    "flowchart" : {"curve" : "linear"}
    }
}%%

%% linkStyle default interpolate basis

flowchart LR

    classDef hidden display: none;

    urlRequest("Url request")

    subgraph compApiController["API component controller"]
        comp_api_controller("Request ()")
    end

    subgraph joomlaApiController["Joomla API controller"]
        joomla_api_controller("Request ()")
    end

    subgraph compApiModel["API component model"]
        comp_api_model("functions ()")
    end

    subgraph compAdminModel["Admin component model"]
        comp_admin_model("functions ()")
    end

    urlRequest --> comp_api_controller
    urlRequest -.-> joomla_api_controller 
%%    urlRequest -.-> joomla_api_controller 
    
    %% comp_api_controller --> joomla_api_controller
    joomla_api_controller --> comp_api_model
    joomla_api_controller -.-> comp_admin_model

%%    compApiController --- compApiModel
```


```mermaid
flowchart
    A-->B[<div style='text-align: left'><h3>Well well well...</h3><ul><li>this is a really</li><li>round-about way to</li><li>do stuff lol...</li></ul><br></div>];
    B-->C;
```

        "curve" : "basis"
        "curve" : "bumpX"
        "curve" : "bumpY"
        "curve" : "cardinal"
        "curve" : "catmullRom"
        "curve" : "linear"
        "curve" : "monotoneX"
        "curve" : "monotoneY"
        "curve" : "natural"
        "curve" : "step"
        "curve" : "stepAfter"
        "curve" : "stepBefore"
        
        
        "theme":"default",
        "theme":"forest",
        "theme":"base",
        "theme":"dark",
        "theme":"neutral",
        
        "useMaxWidth" : "true"
        "useMaxWidth" : "false"
        
        "diagramPadding" : "0",

        "diagramPadding" : "4",
        "diagramPadding" : "32",
        
        "noteSpacing" : "0",
        
        "rankSpacing" : "0",
        "rankSpacing" : "4",

          direction TB


```mermaid
---
"title": "General sequence in joomla api controller function"
---

%%{init:{
    "theme":"forest",
        "theme":"base",

    "flowchart" : {
        "curve" : "step",
         "useMaxWidth" : "true",
         "rankSpacing" : "7",
         "diagramPadding" : "4"
    }
}}%%

flowchart LR
    start[API URL]  ~~~|" "| start --> plg[CRUD function] ~~~|" "| plg
```


