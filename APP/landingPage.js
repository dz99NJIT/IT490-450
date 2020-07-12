function update(){
    setInterval(function(){
      var http=new XMLHttpRequest();
      var post=document.getElementById("posts");
      http.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            post.innerHTML=this.responseText;
          }
      };
      http.open("GET","update.php",true);
      http.send();
    }, 5000);
}
function sendmessage(){
    var username=document.getElementById("username").value;
    var message=document.getElementById("message").value;
    if(message!=""){
        var http=new XMLHttpRequest();
        http.open("GET","sendMessage.php?username=" + username + "&message="+message,true);
        http.send();
        var message="";
        update();
    }
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
    var teamname="";
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
  var http=new XMLHttpRequest();
  http.open("GET","populate.php",true);
  http.send();
  update();
}
function favoriteteam(){
  var username=document.getElementById("username").value;
  var teamId="";
  var action="add";
  var teamresult=document.getElementById("teamresult");
  var http=new XMLHttpRequest();
  http.open("GET","FavoriteTeam.php?username=" + username + "&teamId=" + teamId + "action=" +action,true);
  http.send();
  update();
}
