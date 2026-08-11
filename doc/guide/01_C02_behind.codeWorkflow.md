### Code workflows 

#### URL request to used model

The API call to the controller function like 'displayList' will use the code in the component api controller path if available. 
Otherwise, the default API controller steps in and handles the request. 
In similar way the joomla api controller calls the model creator which tries to find the component api model 
or takes the component administrator model with given name.

```mermaid
---
"title": "Path from URL request to used model"
---
%%{init:{
    "theme":"base",
    "flowchart" : {"curve" : "linear"}
    }
}%%

flowchart LR

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
    
    joomla_api_controller --> comp_api_model
    joomla_api_controller -.-> comp_api_no_model -.-> comp_admin_model

```

#### joomla api controller sequence

```mermaid
---
"title": "General sequence in joomla api controller function"
---
%%{init:{
    "theme":"base",
    
    "flowchart" : {
        "noteSpacing" : "50",
        "diagramPadding" : "4",
        "curve" : "linear"
    }
}}%%

flowchart TB

%% subgraph joomlaApiController [joomla api controller]
%%    direction LR
%%    direction TB

start(('call'))
    
    subgraph generateView["Create view (JsonApiView)"]

        typeNameLayout("Get type, name, layout")
        createView("Create view")
        
        typeNameLayout --> createView
    end

    subgraph generateModel["Model"]
        direction TB

        modelSource("Component api model or <br> component admin model")
        assignModel2View("Assign to view")
        modelState("Handle model state")

        modelSource --> assignModel2View --> modelState
    end
    
    subgraph requestAction["Request action"]
        requestActionTypes("Call add, delete, save ...")
    end

    subgraph callJsonApiDisplay["call display list/item (-> jsonApiView.php)"]
        direction TB

        subgraph jsonApiView["jsonApiView"]
            jsonApiView_DisplayListItem("Display")
            DisplayList("Display list: Calls table for items of type")
            DisplayItem("Display item: Calls table for data with id")
            jsonApiView_DisplayListItem -. List .-> DisplayList
            jsonApiView_DisplayListItem -. Item .-> DisplayItem
        end

    end
%%end

    start --> typeNameLayout
    createView --> modelSource
    modelState --> requestActionTypes
    requestActionTypes --> jsonApiView_DisplayListItem

```

by  Joomla API base classes

List of CRUD controller functions called: 'displayList','displayItem','add','edit (patch)', 'delete'



? Overview diagramm :
comp. control function ? base model or direct model ...




================================
### Workflow get (Item) -> displayItem()

(get with ID on end of route)








================================
### Workflow get (list) -> displayList()

(get with ID on end of route)









================================
### Workflow post -> add()









================================
### Workflow patch -> edit()









================================
### Workflow delete -> delete()









================================
