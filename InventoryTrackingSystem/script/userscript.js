window.addEventListener("load", start, false);

function dateLoader(blockedDates, daterID){
    blockedDates.replace(/\//g, "");
    blockedDates= JSON.parse(blockedDates);
    $(document).ready(function(){
        var date_range = blockedDates;  
        $( "input[id*='"+"start"+daterID+"']" ).datepicker({
            "minDate": new Date(),
            beforeShowDay: function(date) {                
                var string = $.datepicker.formatDate('mm-dd-yy', date);
                for (var i = 0; i < date_range.length; i++) {
                    
                    if (Array.isArray(date_range[i])) {
                        
                        var from = new Date(date_range[i][0]);
                        var to = new Date(date_range[i][1]);
                        var current = new Date(string);
                        
                        if (current >= from && current <= to) return false;
                    }
                    
                }
                return [date_range.indexOf(string) == -1]
            }
        });
    });
}
//, dp2Id,endDate
function endDateloader(itemId,blockedDates){
   
    blockedDates.replace(/\//g, "");
    blockedDates= JSON.parse(blockedDates);
    var startDate= new Date("'"+document.getElementById("startDate"+itemId).value.replaceAll("/","-")+"'");
    var endDate;
    for (let i = 0; i < blockedDates.length; i++) {
        tempDate=new Date("'"+blockedDates[i][0]+"'"); 
        if(startDate.getTime() < tempDate.getTime()){
            tempDate.setDate( tempDate.getDate() - 1 );
            endDate= tempDate;
            break;
        }  
      } 
    var DateOptions = {
        minDate: startDate,
        maxDate: endDate
    }
    $("input[id*='"+"releaseDate"+itemId+"']").datepicker("destroy");
    $("input[id*='"+"releaseDate"+itemId+"']").datepicker(DateOptions);  
}

function start() 
{
    document.getElementById("toRequests").addEventListener("click",show_Requests,false);
    document.getElementById("toProfile").addEventListener("click", show_Profile,false);
    document.getElementById("toEquipment").addEventListener("click",show_Equipment,false);
    document.getElementById("toRoom").addEventListener("click",show_Room,false);
    
}

function show_Equipment(){  
    addClass_withID(false,'Equipment','hidden')
    addClass_withID(true,'Room','hidden')
}
function  show_Room(){
    addClass_withID(false,'Room','hidden')
    addClass_withID(true,'Equipment','hidden')
   
}


function date_Control(){
   // let ele = document.querySelectorAll('input[name^=Date]')

   var a=$( "input[name*='Date']" )
 
    for (var key in a)
        alert(key)
    
    
}

const IDs = {
    "profile": 'toProfile',
    "requests": 'toRequests'};

function  show_Profile(){
    classModifier('profile') 
}
function  show_Requests(){
    classModifier('requests')
}
function classModifier(className){
    
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

