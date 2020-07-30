function deleteFavorite(this){
    var username=document.getElementById("username").value;
    var teamId=document.getElementById("teamId").value;
    var action="delete";
    var teamresult=document.getElementById("teamresult");
    var http=new XMLHttpRequest();
    alert(this);
    http.open("GET","FavoriteTeam.php?username=" + username + "&teamId=" + teamId + "&action=" +action,true);
    http.send();
    show();
}
