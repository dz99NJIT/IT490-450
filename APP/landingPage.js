function update(){
    setInterval(function(){
      var http=new XMLHttpRequest();
      var test=document.getElementById("test");
      http.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          }
      };
      http.open("GET","update.php",true);
      http.send();
    }, 5000);
}
function teamsearch(){
  var teamname=document.getElementById("searchText").value;
  var teamresult=document.getElementById("teamresult");
  if(teamname!=""){
    var http=new XMLHttpRequest();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            teamresult.innerHTML=this.responseText;
        }
    };
    http.open("GET","teamSearch.php?searchText=" + teamname,true);
    http.send();
    var teamname=document.getElementById("searchText").value="";
    update();
}
}
function buttonclick(button){
    var sports =document.getElementsByClassName("sportNews");
    for(var i=0; i<sports.length; i++){
        if(button.value==sports[i].id){
            sports[i].style.display="block";
        }
        else{
          sports[i].style.display="none";

        }
    }
    update();
}
window.onload=function(){
  update();
}
