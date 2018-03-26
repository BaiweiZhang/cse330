function loginAjax(event){

   
	var username = document.getElementById("loginusername").value; // Get the username from the form
	var password = document.getElementById("loginpassword").value; // Get the password from the form
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "login_ajax.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Logged In!");
			var user = jsonData.username;
			var excapeduser = htmlspecialchars(user);
		//	document.getElementById("currentuser").appendChild(document.createTextNode(user));
			document.getElementById("currentuser").innerHTML=escapeduser;
			console.log(user);
			var tok = jsonData.token;
			
		//	$('#currentuser').appendChild(user);
			//user is the one I want 
			//document.write(user2);
			$('#calendar').fullCalendar('refetchEvents');
		}else{
			alert("You were not logged in.  "+jsonData.message);
			var user = jsonData.username;
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 
 function Calendar(month, year) {
  this.month = (isNaN(month) || month == null) ? cal_current_date.getMonth() : month;
  this.year  = (isNaN(year) || year == null) ? cal_current_date.getFullYear() : year;
  this.html = '';
}


 function register(event){
    var username = document.getElementById("loginusername").value; // Get the username from the form
	var password = document.getElementById("loginpassword").value; // 
    console.log(username);
  var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "register.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been registered!");
			
           //  $("p1").show();     $("p2").show();
		}else{
			alert("You were not registeredin.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 
 
 
 
 


 

function logout(event){
        var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "logout.php", true);
        xmlHttp.send(null);
        xmlHttp.addEventListener("load", function(event){
                var jsonData = JSON.parse(event.target.responseText);
                if(jsonData.success){
                        alert("Log out successful!");
						
                  $('#calendar').fullCalendar('removeEvents');
				   $('#calendar').fullCalendar('refetchEvents');
				   var user = jsonData.username;
		//	document.getElementById("currentuser").appendChild(document.createTextNode(user));
			document.getElementById("currentuser").innerHTML=user;
				  
                }else{
                        alert("You were not logged out.");
                }
        }, false);
}










