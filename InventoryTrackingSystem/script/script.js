window.addEventListener("load", start, false);

function start() 
{
    fieldFac();
    document.getElementById("toLogin").addEventListener("click",show_loginPanel,false);
    document.getElementById("toRegister").addEventListener("click",hide_loginPanel,false);
}
function warning(inf){
    inf.replace(/\//g, "");
    a= JSON.parse(inf);
    var inputs = document.getElementById("registerform").elements;
    for (var key in a) {
        inputs[key].value=a[key];}
    fieldDep(inputs["faculty"]);
    document.getElementById('department').value=a['department'];
}

function show_loginPanel(){
     showOrHide(false,'login')
    showOrHide(true,'register')
    document.title="Ancrow - Login Page"
    
     
}
function hide_loginPanel(){
    showOrHide(true,'login')
    showOrHide(false,'register')
    document.title="Ancrow - Register Page"
}

//login validation
function validation(msg){
    if(msg!=''){
    document.getElementById("loginform").setAttribute("onsubmit","return false");
    }
}

//register check password
function checkPassword() {
  const password = document.querySelector('input[id=r_password]');
  const confirm = document.querySelector('input[id=password_repeat]');
  if (confirm.value === password.value) {
    confirm.setCustomValidity('');
  } else {
      confirm.setCustomValidity('Passwords do not match'); 
  }    
}
//register check faculty
function checkFaculty() {
  const confirm = document.querySelector('select[id=faculty]');
  if (confirm.value === 'Select a Faculty') {
    confirm.setCustomValidity('Please Select a Faculty');
  } else {
      confirm.setCustomValidity(''); 
  }    
}
//register check department
function checkDepartment() {
    const confirm = document.querySelector('select[id=department]');
    if (confirm.value === 'Select a Department') {
      confirm.setCustomValidity('Please Select a Department');
    } else {
        confirm.setCustomValidity(''); 
    }    
  }
  
function showOrHide(a,elementID){
    if(a){
        document.getElementById(elementID).classList.add("hidden");
    }
    else
        document.getElementById(elementID).classList.remove("hidden");
}

//department and faculty relation
var arra = {
  "Select a Faculty": [''],
  "FACULTY OF ENGINEERING": ['Select a Department',"Computer Engineering", "Civil Engineering","Electrical and Electronic Engineering","Software Engineering"],
  "FACULTY OF EDUCATION": ['Select a Department',"Guidance and Psychological ", "Counseling","Special Education Teaching","Pre-School Teaching","Primary Education Teaching","English Language Teaching"],
  "FACULTY OF HEALTH SCIENCES": ['Select a Department',"Department of Nutrition and Dietetics","Department of Physical Therapy and Rehabilitation","Department of Nursing"],
  "FACULTY OF FINE ARTS & ARCHITECTURE":['Select a Department',"Interior Architecture and Environmental Design","Department of Architecture"],
  "FACULTY OF COMMUNICATION":['Select a Department',"Visual Communication Design","Radio, Television and Cinema"],
  "FACULTY OF ECONOMICS, ADMINISTRATIVE & SOCIAL SCIENCES":['Select a Department',"Department of Economics","Department of Business Administration","Department of Psychology","Department of Political Sciences and International Relations","Department of International Trade and Logistics"]    
};

function fieldFac(){
    var insideDep="";
    for (var key in arra) {
        insideDep+= "<option value='"+key+"'>"+key+"</option>";
    }
    document.getElementById("faculty").innerHTML=insideDep;
}
function fieldDep(dep){
    var insideDep;
    if(dep.value=="Select a Faculty"){
           showOrHide(true,"department");
       }
    else
        showOrHide(false,"department");
    arra[dep.value].forEach((element) => {
    insideDep+= "<option value='"+element+"'>"+element+"</option>";
});
    document.getElementById("department").innerHTML=insideDep;
}