var rack;
var genericGetRequest = function(URL, callback){
  var xhr = new XMLHttpRequest();
  xhr.onload = function(){
    if (this.status == 200){
      callback(JSON.parse(this.response));
    }
  };
  xhr.open("GET", URL);
  xhr.send();
};

var user;
if(sessionStorage.getItem("Username") == null) {
  user = prompt("Enter your username");
  sessionStorage.setItem("Username",user);
}

function getUser() {
  return sessionStorage.getItem("Username");
}



/*var genericPostRequest = function(URL, callback){
  var post = new XMLHttpRequest();
  post.onload = function(){
    if(this.status == 200){
      callback(JSON.parse(this.response));
    }
  };
  post.open("POST",URL);
  post.send();
};*/

var showMessages = function() {
  genericGetRequest("https://class4-jhowe-dev.c9users.io/server.php",showMessages);
}

/*document.getElementById("enterMessage").addEventListener('click', function(){
  genericPostRequest("https://class4-jhowe-dev.c9users.io/server.php", genericPostRequest);
});*/
