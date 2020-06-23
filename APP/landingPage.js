function update(){
    var http=new XMLHttpRequest();
    var test=document.getElementById("chat");
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText!=""){
                test.innerHTML = test.innerHTML + this.responseText;
            }
        }
    };
    http.open("GET","Api.php",true);
    http.send();
}
function APIcall(){
    var http=new XMLHttpRequest();
    var test=document.getElementById("test");
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //var j = this.responseText;
            //var j = JSON.parse(this.responseText);
            alert(this.responseText);
            alert(j);
            alert(j.draft.id);
        }
    };
    http.open("GET","Api.php",true);
    http.send();
}
function interval(){
    setInterval(function(){
        APIcall();
        update();
    }, 5000);

}
window.onload=function(){
    update();
    interval();
}
