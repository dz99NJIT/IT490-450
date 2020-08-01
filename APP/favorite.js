function show(){
  var http=new XMLHttpRequest();
  var username=document.getElementById("username").value;
  var post=document.getElementById("favoriteTeams");
  http.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        post.innerHTML=this.responseText;
      }
  };
  http.open("GET","favorite.php?username=" + username,true);
  http.send();
}
function deleteFavorite(element){
  var username=document.getElementById("username").value;
  var teamId=element.parentElement.id;
  var action="delete";
  var teamresult=document.getElementById("teamresult");
  var http=new XMLHttpRequest();
  http.open("GET","AddFavoriteTeam.php?username=" + username + "&teamId=" + teamId + "&action=" +action,true);
  http.send();
  show();
}
window.onload=function(){
  show();
}
