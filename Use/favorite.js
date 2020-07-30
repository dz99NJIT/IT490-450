function deleteFavorite(element){
    var username=document.getElementById("username").value;
    var teamId=element.parentElement.id;
    var action="delete";
    var teamresult=document.getElementById("teamresult");
    var http=new XMLHttpRequest();
    http.open("GET","FavoriteTeam.php?username=" + username + "&teamId=" + teamId + "&action=" +action,true);
    http.send();
    show();
}
