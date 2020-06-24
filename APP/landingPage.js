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

window.onload=function(){
    var http=new XMLHttpRequest();
    var test=document.getElementById("test");
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //var j = this.responseText;
            var j = JSON.parse(this.responseText);
        }
    };
    http.open("GET","update.php",true);
    http.send();
}
