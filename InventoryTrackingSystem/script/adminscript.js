window.addEventListener("load", start, false);

function start() 
{
    document.getElementById("toEquipment").addEventListener("click",show_Equipment,false);
    document.getElementById("toRoom").addEventListener("click",show_Room,false);
    document.getElementById("toEquipment_inuse").addEventListener("click",show_Equipment_inuse,false);
    document.getElementById("toRoom_inuse").addEventListener("click",show_Room_inuse,false);
    for (var key in IDs) {
        document.getElementById(IDs[key]).addEventListener('click', classModifier, false);
        document.getElementById(IDs[key]).myParam = key;
    };
    
}

function show_Equipment(){  
    addClass_withID(false,'Equipment','hidden')
    addClass_withID(true,'Room','hidden')
}
function  show_Room(){
    addClass_withID(false,'Room','hidden')
    addClass_withID(true,'Equipment','hidden')
   
}
function show_Equipment_inuse(){  
    addClass_withID(false,'Equipment_inuse','hidden')
    addClass_withID(true,'Room_inuse','hidden')
}
function  show_Room_inuse(){
    addClass_withID(false,'Room_inuse','hidden')
    addClass_withID(true,'Equipment_inuse','hidden')
   
}
const IDs = {
    "profile": 'toProfile',
    "active_ones": 'toActiveOnes',
    "requests": 'toRequests',
    "registrations": 'toRegistrations',
    "request_history":'toHistoryR',
    "deliveries_history":'toHistoryD'};

function classModifier(className){
    
    className=className.currentTarget.myParam
    for (var key in IDs) {
        if(key!=className){
            addClass_withID(true,key,'hidden')
            changeColor(false,IDs[key])
        }
        else{
            addClass_withID(false,key,'hidden')
            changeColor(true,IDs[key])
        }
    }
}   

function changeColor(selected,elementID){
    if(selected){
        document.getElementById(elementID).setAttribute("style","color: black");
    }
    else
        document.getElementById(elementID).setAttribute("style","color: #c2c2c2");
}

function addClass_withID(a,elementID,className){
    if(a){
        document.getElementById(elementID).classList.add(className);
    }
    else
        document.getElementById(elementID).classList.remove(className);
}

