function favoriteteam(teamname){
  var username=document.getElementById("username").value;
  var teamId=document.getElementById("teamId").value;
  var action="add";
  alert(teamId);
  var teamresult=document.getElementById("teamresult");
  var http=new XMLHttpRequest();
  http.open("GET","FavoriteTeam.php?username=" + username + "&teamId=" + teamId + "action=" +action,true);
  http.send();
}
