function processLogin(){
  var userName = getCookie('username');

  document.getElementById('loginBox').style.visibility = "hidden";
  document.getElementById('loginBoxForm').style.visibility = "visible";
}

function processLogout(){
  var box = document.getElementById('loginBox');
  var xmlhttp = new XMLHttpRequest();
  var width = box.offsetWidth;
  
  eraseCookie('username');
  eraseCookie('userLevel');
  location.reload();
}

function hideLogin(){
  document.getElementById('loginBox').style.visibility = "visible";
  document.getElementById('loginBoxForm').style.visibility = "hidden";
}

function loadUser(){
  var userName = getCookie('username');
  var login = document.getElementById('loginLogin');
  var logout = document.getElementById('loginLogout');
  var box = document.getElementById('loginBox');
  var startingWidth = box.offsetWidth;
  var width;
  var pos;
  
  if(userName == null){
    startingWidth = startingWidth - login.offsetWidth - logout.offsetWidth;
    login.innerHTML = "Login";
    logout.innerHTML = "";
    width = startingWidth + login.offsetWidth + logout.offsetWidth;
    pos = logout.offsetWidth + 10;
    login.style.right = pos+"px";
    logout.style.right = "0px";
    logout.style.top = "0.5em";
    box.style.width = width+"px";
  }else{
    startingWidth = startingWidth - login.offsetWidth - logout.offsetWidth;
    login.innerHTML = userName;
    logout.innerHTML = "Logout";
    width = startingWidth + login.offsetWidth + logout.offsetWidth;
    pos = logout.offsetWidth + 10;
    login.style.right = pos+"px";
    logout.style.right = "0px";
    logout.style.top = "0.5em";
    box.style.width = width+"px";
  }
}

function showUser(userId){
  var xmlhttp = new XMLHttpRequest();
  var width;
  var startingWidth;
  var url;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById('editUser').innerHTML=xmlhttp.responseText;
      if(userId){
        document.getElementById('editBox').style.width="82px";
      }
    }
  }
  if(userId){
    url = "/scripts/ajax/showUser.php?u="+userId;
  } else {
    url = "/scripts/ajax/showUser.php";
  }
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function hideUser(){
  document.getElementById('editUser').innerHTML="";
}

function saveNewUser(){
var xmlhttp = new XMLHttpRequest();
var xmlhttp2 = new XMLHttpRequest();

  xmlhttp2.onreadystatechange=function(){
    if(xmlhttp2.readyState==4 && xmlhttp2.status==200){
      document.getElementById('allUsers').innerHTML=xmlhttp2.responseText;
    }
  }
  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      showUser(getCookie('lastUser'));
      xmlhttp2.open("GET","/scripts/ajax/updateUserList.php",true);
      xmlhttp2.send();
    }
  }
  xmlhttp.open("GET","/scripts/ajax/saveNewUser.php",true);
  xmlhttp.send();
}

function deleteUser(usrId){
  var xmlhttp = new XMLHttpRequest();
  var xmlhttp2 = new XMLHttpRequest();

  xmlhttp2.onreadystatechange=function(){
    if(xmlhttp2.readyState==4 && xmlhttp2.status==200){
      document.getElementById('allUsers').innerHTML=xmlhttp2.responseText;
    }
  }
  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      xmlhttp2.open("GET","/scripts/ajax/updateUserList.php",true);
      xmlhttp2.send();
    }
  }
  if(confirm("Are you sure you want to delete this user?")){
    hideUser();
    if(usrId){
      xmlhttp.open("GET","/scripts/ajax/deleteUser.php?u="+usrId,true);
      xmlhttp.send();
    }
  }
}

function addProject(){
  var editButton = document.getElementById('editButton')
  var addButton = document.getElementById('addButton');
  var editButtonParent = editButton.parentNode;
  var addButtonParent = addButton.parentNode;
  var saveButton = document.createElement('input')
  var cancelButton = document.createElement('input')
  var table = document.getElementById('projectTable');
  var row = table.insertRow(1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  var xmlhttp = new XMLHttpRequest();

  saveButton.type = "submit";
  saveButton.id = "saveButton";
  saveButton.value = "Save";
  saveButton.className = "filterButton"
  saveButton.name = "sButton";
  saveButton.onclick = function(){saveAdd(this)};
  cancelButton.type = "submit";
  cancelButton.id = "cancelButton";
  cancelButton.value = "Cancel";
  cancelButton.className = "filterButton"
  cancelButton.name = "cButton";
  cancelButton.onclick = function(){cancelAdd(this)};

  editButtonParent.replaceChild(cancelButton,editButton);
  addButtonParent.replaceChild(saveButton,addButton);

  table.className = "addRowDisp";

  cell1.className = "col1 newCell";
  cell2.className = "col2 newCell";
  cell3.className = "col3 newCell";
  cell4.className = "engineerCell col4 newCell";
  cell5.className = "col5 newCell";
  cell6.className = "col6 newCell";
  
  cell1.innerHTML = "<div id='numnew' class='projectEditField newProjectValue' onclick='editProjectFieldInput(this,\"new\",\"ies_num\")'>...New...</div>";
  cell2.innerHTML = "<div id='namenew' class='projectEditField newProjectValue' onclick='editProjectFieldInput(this,\"new\",\"name\")'>...New...</div>";
  cell3.innerHTML = "<div id='customernew' class='projectEditField newProjectValue' onclick='editProjectFieldInput(this,\"new\",\"customer\")'>...New...</div>";
  cell4.innerHTML = "<div id='engineer0new' class='nowrapDiv projectEditField newProjectValue' onclick='editProjectFieldEngineer(this,\"new\",0)'>...New...</div>";
  cell5.innerHTML = "<div id='svn0new' class='nowrapDiv projectEditField newProjectValue' onclick='editProjectFieldSVN(this,\"new\",0,event)'>...New...</div>";
  cell6.innerHTML = "<div id='notesnew' class='projectEditField newProjectValue' onclick='editProjectFieldNotes(this,\"new\")'>...New...</div>";

  xmlhttp.open("GET","/scripts/ajax/resetNew.php",true);
  xmlhttp.send();
}

function cancelAdd(el){
  var saveButton = document.getElementById('saveButton')
  var cancelButton = document.getElementById('cancelButton');
  var saveButtonParent = saveButton.parentNode;
  var cancelButtonParent = cancelButton.parentNode;
  var editButton = document.createElement('input')
  var addButton = document.createElement('input')
  var table = document.getElementById('projectTable');
  
  el.blur();

  table.className = "";

  table.deleteRow(1);

  editButton.type = "submit";
  editButton.id = "editButton";
  editButton.value = "Edit";
  editButton.className = "filterButton"
  editButton.name = "eButton";
  editButton.onclick = function(){filter(document.getElementById('fIESnumSelect').value,document.getElementById('fTypeSelect').value,1)};
  addButton.type = "submit";
  addButton.id = "addButton";
  addButton.value = "Add";
  addButton.className = "filterButton"
  addButton.name = "aButton";
  addButton.onclick = function(){addProject()};

  cancelButtonParent.replaceChild(editButton,cancelButton);
  saveButtonParent.replaceChild(addButton,saveButton);
}

function saveAdd(el){
  var xmlhttp = new XMLHttpRequest();
  var name = document.getElementById('fIESnumSelect').value;
  var type = document.getElementById('fTypeSelect').value;

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      filter(name,type,0,0);
      cancelAdd(el)
    }
  }
  xmlhttp.open("GET","/scripts/ajax/saveAddProject.php",true);
  xmlhttp.send();
}

function archiveAllProjects(){
  var checkboxes = document.getElementsByClassName('archiveCheckbox');
  var i=0;
  var name = document.getElementById('fIESnumSelect').value;
  var type = document.getElementById('fTypeSelect').value;

  for(i=0;i<checkboxes.length;i++){
    if(checkboxes.item(i).checked){
      archiveProject(checkboxes.item(i).value);
      checkboxes.item(i).checked = false;
    }
  }
}

function archiveProject(iesNum){
  var xmlhttp = new XMLHttpRequest();

  if(iesNum){
    xmlhttp.open("GET","/scripts/ajax/archiveProject.php?i="+iesNum,false);
    xmlhttp.send();
    filter();
  }
}

function editProjectFieldInput(el,iesNum,field){
  var node=el.parentNode;
  var input=document.createElement('input');
  var text=el.innerHTML;

  with(input){
    if(iesNum != 'new'){
      setAttribute('value',text,0);
    }else{
      setAttribute('placeholder',"...New...",0);
    }
    setAttribute('size',text.length-1,0);
    style.width = node.offsetWidth-10+'px';
    setAttribute('class',el.className,0);
    setAttribute('type','text',0);
    setAttribute('id',el.id,0);
    setAttribute('onblur','saveProjectFieldInput(this,\''+iesNum+'\',\''+field+'\')',0);
    setAttribute('onkeydown','validateEditProjectEnter(this,event)',0);
  }
  node.replaceChild(input,el);
  input.focus();
  input.setSelectionRange(input.value.length,input.value.length);
}

function editProjectFieldEngineer(el,iesNum,engIndex){
  var node=el.parentNode;
  var xmlhttp = new XMLHttpRequest();

  if(!node)
    return;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      node.innerHTML = xmlhttp.responseText;
      document.getElementById(el.id).focus();
    }
  }
  if(el&&iesNum&&(engIndex>=0)){
    xmlhttp.open("GET","/scripts/ajax/displayEngineerList.php?i="+iesNum+"&e="+engIndex,true);
    xmlhttp.send();
  }
}

function editProjectFieldSVN(el,iesNum,SVNindex,e){
  var node=el.parentNode;
  var xmlhttp = new XMLHttpRequest();
  var input;

  e.preventDefault();

  if(!node)
    return;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      node.innerHTML = xmlhttp.responseText;
      input = document.getElementById(el.id);
      input.focus();
      input.setSelectionRange(input.value.length,input.value.length);
    }
  }
  if(el&&iesNum&&(SVNindex>=0)){
    xmlhttp.open("GET","/scripts/ajax/displaySVNlist.php?i="+iesNum+"&s="+SVNindex,true);
    xmlhttp.send();
  }
}

function editProjectFieldNotes(el,iesNum){
  var node=el.parentNode;
  var xmlhttp = new XMLHttpRequest();
  var textarea;

  if(!node)
    return;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      node.innerHTML = xmlhttp.responseText;
      textarea = document.getElementById(el.id);
      textarea.focus();
      textarea.setSelectionRange(textarea.value.length,textarea.value.length);
      setTextAreaHeight(textarea);
    }
  }
  if(el&&iesNum){
    xmlhttp.open("GET","/scripts/ajax/displayNotes.php?i="+iesNum,true);
    xmlhttp.send();
  }
}

function validateEditProjectEnter(el,e){
  if(e.keyCode == 13){
    e.preventDefault();
    el.blur();
  }
}

function setTextAreaHeight(text){
  var windowScroll = window.pageYOffset;
  var h=0;

  while((text.rows > 1)&&(text.scrollHeight < text.offsetHeight)){
    text.rows--;
  }
  while((text.scrollHeight > text.offsetHeight)){
    h=text.offsetHeight;
    text.rows++;
  }
  window.scrollTo(0,windowScroll);
}

function saveProjectFieldInput(el,iesNum,field){
  var node=el.parentNode;
  var div=document.createElement('div');
  var text=el.value;
  var xmlhttp=new XMLHttpRequest();

  with(div){
    setAttribute('id', el.id, 0);
    setAttribute('class', el.className, 0);
    setAttribute('onclick', 'editProjectFieldInput(this,\''+iesNum+'\',\''+field+'\')', 0);
    if(text){
      div.style.color = "black";
    }else{
      text = "...New...";
    }
  }
  div.innerHTML = text;
  node.replaceChild(div,el);

  xmlhttp.open("GET","/scripts/ajax/saveProjectFieldInput.php?i="+iesNum+"&f="+field+"&v="+text,true);
  xmlhttp.send();
}

function saveProjectFieldEngineer(el,iesNum,engIndex,totalE){
  var node=el.parentNode;
  var div=document.createElement('div');
  var text=el.options[el.options.selectedIndex].text;
  var value=el.options[el.options.selectedIndex].value;
  var xmlhttp=new XMLHttpRequest();

  if(!node)
    return;

  with(div){
    setAttribute('id', el.id, 0);
    setAttribute('class', el.className, 0);
    setAttribute('onclick', 'editProjectFieldEngineer(this,\''+iesNum+'\','+engIndex+')', 0);
  }
  if(text){
    div.innerHTML = text;
  }else if(engIndex == totalE){
    div.innerHTML = "...New...";
  }else{
    div.innerHTML = "None";
    div.className = el.className+" newProjectValue";
  }
  node.replaceChild(div,el);

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      node.innerHTML = xmlhttp.responseText;
    }
  }

  xmlhttp.open("GET","/scripts/ajax/saveProjectFieldEngineer.php?i="+iesNum+"&e="+engIndex+"&v="+value,true);
  xmlhttp.send();
}

function saveProjectFieldSVN(el,iesNum,SVNindex){
  var node=el.parentNode;
  var xmlhttp=new XMLHttpRequest();
  var value;

  if(!node)
    return;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      node.innerHTML = xmlhttp.responseText;
    }
  }
  if(!el.value){
    value = "blank";
  }else{
    value = el.value;
  }
  xmlhttp.open("GET","/scripts/ajax/saveProjectFieldSVN.php?i="+iesNum+"&s="+SVNindex+"&v="+value,true);
  xmlhttp.send();
}

function saveProjectFieldNotes(el,iesNum){
  var node=el.parentNode;
  var xmlhttp=new XMLHttpRequest();

  if(!node)
    return;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      node.innerHTML = xmlhttp.responseText;
    }
  }

  xmlhttp.open("POST","/scripts/ajax/saveProjectFieldNotes.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("i="+iesNum+"&v="+el.value);
}

function showUtil(util){
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById('utils').innerHTML = xmlhttp.responseText;
    }
  }

  if(util == 'svn'){
    url = "";
  }
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function aToInput(el,usrId){
  var node=el.parentNode;
  var input=document.createElement('input');
  var text=el.innerHTML;

  if(usrId){
    with (input){
      setAttribute('value', text, 0);
      setAttribute('size', text.length-1, 0);
      style.width = document.all&&!window.opera? el.offsetWidth-2+'px' : el.offsetWidth+2+'px';
      setAttribute('class', el.className, 0);
      setAttribute('onblur', 'inputToA(this,'+usrId+')', 0);
      setAttribute('onkeydown', 'validateEditUsrEnter(this)', 0);
      if(el.id == "emailValue"){
        setAttribute('type', 'email', 0);
      } else {
        setAttribute('type', 'text', 0);
      }
      setAttribute('id', el.id, 0);
    }
    node.replaceChild(input,el);
    input.focus();
    input.setSelectionRange(input.value.length,input.value.length);
  } else {
    with(input){
      if(el.id == "fnameValue"){
        setAttribute('placeholder', 'First Name', 0);
      } else if(el.id == "lnameValue") {
        setAttribute('placeholder', 'Last Name', 0);
      } else if(el.id == "usernameValue") {
        setAttribute('placeholder', 'username', 0);
      } else if(el.id == "passwordValue") {
        setAttribute('placeholder', 'password', 0);
      } else if(el.id == "titleValue") {
        setAttribute('placeholder', 'Engineer', 0);
      } else if(el.id == "svnValue") {
        setAttribute('placeholder', 'SVN username', 0);
      } else if(el.id == "emailValue") {
        setAttribute('placeholder', 'email@ies-us.com', 0);
      }
      setAttribute('class', el.className, 0);
      setAttribute('onblur', 'inputToA(this)', 0);
      setAttribute('onkeydown', 'validateEditUsrEnter(this)', 0);
      setAttribute('type', 'text', 0);
      setAttribute('id', el.id, 0);
    }
    node.replaceChild(input,el);
    input.focus();
    input.setSelectionRange(input.value.length,input.value.length);
  }
}

function aToDeptSelect(el,usrId){
  var node=el.parentNode;
  var select=document.createElement('select');
  var opt1=document.createElement('option');
  var opt2=document.createElement('option');
  var opt3=document.createElement('option');
  var opt4=document.createElement('option');
  var opt5=document.createElement('option');
  var text=el.innerHTML;
  var i;

  opt1.value = 1;
  opt1.innerHTML = "Electrical";
  opt2.value = 2;
  opt2.innerHTML = "Mechanical";
  opt3.value = 3;
  opt3.innerHTML = "Logistics";
  opt4.value = 4;
  opt4.innerHTML = "Software";
  opt5.value = 5;
  opt5.innerHTML = "Manufacturing";
  select.appendChild(opt1);
  select.appendChild(opt2);
  select.appendChild(opt3);
  select.appendChild(opt4);
  select.appendChild(opt5);
  for(i=0;i<select.options.length;i++){
    if(text == select.options[i].text){
      select.options[i].selected = true;
    }
  }
  with (select){
    setAttribute('id', el.id, 0);
    setAttribute('class', el.className, 0);
    if(usrId){
      setAttribute('onblur', 'deptSelectToA(this,'+usrId+')', 0);
    } else {
      setAttribute('onblur', 'deptSelectToA(this)', 0);
    }
    setAttribute('onkeydown', 'validateEditUsrEnter(this)', 0);
    style.height = el.offsetHeight+"px";
  }
  node.replaceChild(select,el);
  select.focus();
}

function aToLevelSelect(el,usrId){
  var node=el.parentNode;
  var select=document.createElement('select');
  var opt1=document.createElement('option');
  var opt2=document.createElement('option');
  var text=el.innerHTML;
  var i;

  opt1.value = 1;
  opt1.innerHTML = "User";
  opt2.value = 15;
  opt2.innerHTML = "Admin";
  select.appendChild(opt1);
  select.appendChild(opt2);
  for(i=0;i<select.options.length;i++){
    if(text == select.options[i].text){
      select.options[i].selected = true;
    }
  }
  with (select){
    setAttribute('id', el.id, 0);
    setAttribute('class', el.className, 0);
    if(usrId){
      setAttribute('onblur', 'levelSelectToA(this,'+usrId+')', 0);
    } else {
      setAttribute('onblur', 'levelSelectToA(this)', 0);
    }
    setAttribute('onkeydown', 'validateEditUsrEnter(this)', 0);
    style.height = el.offsetHeight+"px";
  }
  node.replaceChild(select,el);
  select.focus();
}

function spanToBossSelect(el,usrId){
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById('bossValue').innerHTML = xmlhttp.responseText;
      document.getElementById('bossValue').firstChild.focus();
    }
  }

  if(usrId){
    xmlhttp.open("GET","/scripts/ajax/fillEmpSelectList.php?t=b&u="+usrId,true);
  }else{
    xmlhttp.open("GET","/scripts/ajax/fillEmpSelectList.php?t=b",true);
  }
  xmlhttp.send();
}

function bossSelectToSpan(el,usrId){
  var xmlhttp = new XMLHttpRequest();
  var value = el.options[el.options.selectedIndex].value;

  xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById('bossValue').innerHTML = xmlhttp.responseText;
    }
  }

  if(usrId){
    xmlhttp.open("GET","/scripts/ajax/saveUserData.php?i="+usrId+"&f="+el.id+"&v="+value,true);
  }else{
    xmlhttp.open("GET","/scripts/ajax/saveUserData.php?f="+el.id+"&v="+value,true);
  }
  xmlhttp.send();
}

function deptSelectToA(el,usrId){
  var node = el.parentNode;
  var a = document.createElement('a');
  var text = el.options[el.options.selectedIndex].text;
  var value = el.options[el.options.selectedIndex].value;
  var xmlhttp=new XMLHttpRequest();
  var url;

  with(a){
    setAttribute('class', el.className, 0);
    setAttribute('id', el.id, 0);
    if(usrId){
      setAttribute('onclick', 'aToDeptSelect(this,'+usrId+')', 0);
    } else {
      setAttribute('onclick', 'aToDeptSelect(this)', 0);
    }
  }
  a.innerHTML = text;
  a.href = "#";
  node.replaceChild(a,el);

  if(usrId){
    url = "/scripts/ajax/saveUserData.php?i="+usrId+"&f="+a.id+"&v="+value;
  } else {
    url = "/scripts/ajax/saveUserData.php?f="+a.id+"&v="+value;
  }
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function levelSelectToA(el,usrId){
  var node = el.parentNode;
  var a = document.createElement('a');
  var text = el.options[el.options.selectedIndex].text;
  var value = el.options[el.options.selectedIndex].value;
  var xmlhttp=new XMLHttpRequest();
  var url;

  with(a){
    setAttribute('class', el.className, 0);
    setAttribute('id', el.id, 0);
    if(usrId){
      setAttribute('onclick', 'aToLevelSelect(this,'+usrId+')', 0);
    } else {
      setAttribute('onclick', 'aToLevelSelect(this)', 0);
    }
  }
  a.innerHTML = text;
  a.href = "#";
  node.replaceChild(a,el);

  if(usrId){
    url = "/scripts/ajax/saveUserData.php?i="+usrId+"&f="+a.id+"&v="+value;
  } else {
    url = "/scripts/ajax/saveUserData.php?f="+a.id+"&v="+value;
  }
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function validateEditUsrEnter(el){
  var e = window.event;

  if(e.keyCode == 13){
    e.preventDefault();
    el.blur();
  }
}

function inputToA(el,usrId){
  var node=el.parentNode;
  var a=document.createElement('a');
  var text=el.value;
  var xmlhttp=new XMLHttpRequest();
  var url;

  with(a){
    setAttribute('class', el.className, 0);
    setAttribute('id', el.id, 0);
    if(usrId){
      setAttribute('onclick', 'aToInput(this,'+usrId+')', 0);
    } else {
      setAttribute('onclick', 'aToInput(this)', 0);
    }
    if(!text && (el.id == "fnameValue")){
      text = "First";
    } else if(!text && (el.id == "lnameValue")){
      text = "Last";
    }
  }
  a.href = "#";
  a.innerHTML = text;
  node.replaceChild(a,el);

  if(usrId){
    url = "/scripts/ajax/saveUserData.php?i="+usrId+"&f="+a.id+"&v="+text;
  } else {
    url = "/scripts/ajax/saveUserData.php?f="+a.id+"&v="+text;
  }
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function filter(name,type,editModel,arch){
  var xmlhttp = new XMLHttpRequest();
  var url = "/scripts/ajax/filterProjects.php";

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("projectsTable").innerHTML=xmlhttp.responseText;
    }
  }

  if(name||type||(editModel>=0)||(arch>=0)){
    url+="?";
  }
  if(name){
    url+="n="+name;
    if(type||(editModel>=0)||(arch>=0)){
      url+="&";
    }
  }
  if(type){
    url+="t="+type;
    if((editModel>=0)||(arch>=0)){
      url+="&";
    }
  }
  if(editModel>=0){
    url+="e="+editModel;
    if(arch>=0){
      url+="&";
    }
  }
  if(arch>=0){
    url+="a="+arch;
  }
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function fillFilter(name,type,editModel,arch){
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("searchBox").innerHTML=xmlhttp.responseText;
      filter(name,type,editModel,arch);
    }
  }
  xmlhttp.open("GET","/scripts/ajax/fillSearch.php?n="+name+"&t="+type,true);
  xmlhttp.send();
}

/////// OVERHEAD ////////

if (typeof String.prototype.trimLeft !== "function") {
    String.prototype.trimLeft = function() {
        return this.replace(/^\s+/, "");
    };
}
if (typeof String.prototype.trimRight !== "function") {
    String.prototype.trimRight = function() {
        return this.replace(/\s+$/, "");
    };
}
if (typeof Array.prototype.map !== "function") {
    Array.prototype.map = function(callback, thisArg) {
        for (var i=0, n=this.length, a=[]; i<n; i++) {
            if (i in this) a[i] = callback.call(thisArg, this[i]);
        }
        return a;
    };
}
function getCookies() {
    var c = document.cookie, v = 0, cookies = {};
    if (document.cookie.match(/^\s*\$Version=(?:"1"|1);\s*(.*)/)) {
        c = RegExp.$1;
        v = 1;
    }
    if (v === 0) {
        c.split(/[,;]/).map(function(cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function($0, $1) {
            var name = $0,
                value = $1.charAt(0) === '"'
                          ? $1.substr(1, -1).replace(/\\(.)/g, "$1")
                          : $1;
            cookies[name] = value;
        });
    }
    return cookies;
}
function getCookie(name) {
    return getCookies()[name];
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
