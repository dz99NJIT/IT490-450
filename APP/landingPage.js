function update(){
    var http=new XMLHttpRequest();
    var test=document.getElementById("test");
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        }
    };
    http.open("GET","update.php",true);
    http.send();
}
function teamsearch(){
  
}
function buttonclick(button){
    //alert(button.value);
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
