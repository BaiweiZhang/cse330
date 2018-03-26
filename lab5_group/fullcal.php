<?php
ini_set ("session.cookie_httponly",1);
session_start();
$_SESSION['token'] = substr(md5(rand()), 0, 10);
//if (isset($_SESSION['username'])) { 
//		$_SESSION['loggedin'] = true;
//		
//	}
//	else {
//		$_SESSION['loggedin'] = false;
//	
//	}
//	$_SESSION['username']= "guest";

//echo ($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YouCalendar</title>
	
	<!-- External Stylesheets -->
		<link rel='stylesheet' href='ab.css' />
	<link rel='stylesheet' href='/~thierry1129/mod7/fullcalendar.css' />
		<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.css' />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	
	<!-- jQuery & jQueryUI library -->
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.js"></script>
		<!--skeleton for jquery-ui dialog box-->
		<script>
			$( function() {
			  $( "#dialog" ).dialog({
				autoOpen: false,
				show: {
				  effect: "blind",
				  duration: 1000
				},
				hide: {
				  effect: "explode",
				  duration: 1000
				}
			  });
		   
			  $( "#opener" ).on( "click", function() {
				$( "#dialog" ).dialog( "open" );
			  });
			} );
		</script>
		
	<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	<!--Funtionality Scripts -->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>-->
 <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src='/~thierry1129/mod7/moment.min.js'></script>
<script src='/~thierry1129/mod7/fullcalendar.js'></script>
<script src='/~thierry1129/mod7/calendar.js'></script>
		<script>
		$(document).ready(function() {
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				eventSources: [{
					url: 'loadevents.php',
					 color: 'blue',
					textColor: 'black'
				},
				{
					url: 'loadguest.php',
					textColor: 'black',
					 color: 'yellow'
				}
				],
			//events: 'loadevents.php',
				selectable: true,			
				editable :true,
				eventRender: function(event, element) {
					element.bind('mousedown', function(e){
						if (e.which == 3 ){
							//alert ('right mouse clicked');
							var shareuser= prompt('Enter the username that you want to share this event with (If you want to share with everyone, enter "guest"):', event.title, { buttons: { Ok: true, Cancel: false} });
							if (shareuser){
								//calEvent.title = title;
								var start = $.fullCalendar.moment(event.start).format();
								var end = $.fullCalendar.moment(event.end).format();
								var detail = event.eventdetail;
								var id = event.eventid;
								//console.log(start);
								//console.log(title);
								//console.log(detail);
								//  $('#calendar').fullCalendar('updateEvent', calEvent);
								// console.log("executed");
								request =   $.ajax({
									type:"POST",
									url: "shareevent.php",
		
									data:{
										title: event.title,
										detail: event.eventdetail,
										mergedate:start,
										mergeenddate : end,
										shareuser : shareuser
									},
									dataType: 'json',
									success: function(data){
										$('#calendar').fullCalendar('refetchEvents');
										alert("success");
									},
									fail: function(data){
										alert("fail"+jsonData.message);
									}		  
								});
							}
						}
					});		 
					element.append( "<button class='btn closeon'>Delete</button>" );
					element.qtip({
						content: "your event id is "+event.eventid+"&nbsp;&nbsp;your event detail is "+event.eventdetail + '<br />' + "&nbsp;&nbsp;your event start time  is "+$.fullCalendar.moment(event.start).format() + + '<br />'+"&nbsp;&nbsp;your event end  time  is "+$.fullCalendar.moment(event.end).format(),
						style: {
							background: 'black',
							color: '#FFFFFF'
						},
						position: {
							corner: {
								target: 'center',
								tooltip: 'bottomMiddle'
							}
						}
					});
					element.find(".closeon").click(function() {
						$('#calendar').fullCalendar('removeEvents',event._id);
						var id = event.eventid;
						$.ajax({
							type:"POST",
							url: "deleteevent.php",
							data: 'id='+id,
							success: function(data){
								alert("Successfully deleted event.");
							}	  
						}); 
					});
				},	
				selectHelper: true,
				
				eventDrop: function(event, delta) {
					var detail =event.eventdetail;
					var mergedate= $.fullCalendar.moment(event.start).format();
					var mergeenddate = $.fullCalendar.moment(event.end).format();
						// var token = '<?php  $_SESSION['token']; ?>';
					
					$.ajax({
						url: 'updateevent.php',
						data: 'title='+event.title+'&detail='+ detail+'&mergedate='+mergedate+'&mergeenddate='+mergeenddate+'&id='+event.eventid+'&token='+tok,
						type: "POST",
						success: function(json){
							alert("Updated Successfully");
						}
					});
				},
				eventClick: function(calEvent, jsEvent, view) {
					
					
					//var title = prompt('Enter a New Event Title:', calEvent.title, { buttons: { Ok: true, Cancel: false} });
					$("#dialog3").dialog("open");
					
					
					
				}
			});
		});
		</script>
</head>
<body>
<!--	section for login/welcome header-->
	<section class="bg-primary" id="welcome">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6 text-left">
					<h1 id="homeHeading"> Welcome!</h1>
				</div>
				<div class="col-lg-6 text-right">
						<br><br>
						<form class="text-right" id="loginwidget">
							<label> Username </label>
							<input type="text" name="username" id="loginusername"/>
							<label> Password </label>
							<input type="password" name="password" id="loginpassword"/>
							<input type='button' class="btn"  onclick="loginAjax();" value='login' /><br><br>
							<!--//<button class="btn" onclick="loginAjax();">Login</button><br><br>-->
							<label>New here? Enter a username and password above </label>
							<input type='button' class="btn"  onclick="register();" value='register' /><br><br>
						</form>
				</div>
			</div>
		</div>
	</section>
	<!--dialogue box section-->
	<section id="new">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 text-right">
					<button id = "createEvent" class="btn">Create a New Event</button>
					<div id= "dialog2" title= "Add New Event">
						<p>What's the name of your event?<br>
							<input type= "text" id= "eventtitle">
						</p>
						<p>Event details:<br>
							<input type= "text" id= "eventdetail">
						</p>
						<p>Start date:<br>
							<input type="date" id="eventdate">
						</p>
						<p>End date:<br>
							<input type="date" id="eventenddate">
						</p>
						<p>Start time:<br>
							<input type="time" id="eventtime">
						</p>
						<p>End time:<br>
							<input type="time" id="eventendtime">
						</p>	
					</div>
					<div id= "dialog3" title= "Edit your event ">
						<p>What's the name of your event?<br>
							<input type= "text" id= "eventtitle">
						</p>
						<p>Event details:<br>
							<input type= "text" id= "eventdetail">
						</p>
						<p>Start date:<br>
							<input type="date" id="eventdate">
						</p>
						<p>End date:<br>
							<input type="date" id="eventenddate">
						</p>
						<p>Start time:<br>
							<input type="time" id="eventtime">
						</p>
						<p>End time:<br>
							<input type="time" id="eventendtime">
						</p>
						<p>id of event <br>
							<input type="text" id="eventid">
						</p>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--script that births the dialog box-->
	
		<script>
			

			$("#dialog3").dialog({
			show: {
				  effect: "blind",
				  duration: 1000
			},
			hide: {
				  effect: "explode",
				  duration: 1000
			},
			autoOpen:false,
			position:   { my: "center", at: "center", of: window },	
			buttons: {
				Ok: function(){
					request = $.ajax({
						type:"POST",
						url: "updateevent.php",
						data:{
							title: $("#eventtitle").val(),
							detail: $('#eventdetail').val(),
							mergedate: $('#eventdate').val()+" "+ $("#eventtime").val(),
							mergeenddate : $('#eventenddate').val()+" "+ $('#eventendtime').val(),
							id : $("#eventid").val(),
							
						}, dataType: 'json',
					   success: function(data){
							$('#calendar').fullCalendar('refetchEvents');
							alert("success");
					   }  
					});
					$(this).dialog("close");	
				},
				Cancel:function(){
				   $(this).dialog("close");
				}
			}
		});
		</script>
	<script>
	$(function(){
		$("#dialog2").dialog({
			show: {
				  effect: "blind",
				  duration: 1000
			},
			hide: {
				  effect: "explode",
				  duration: 1000
			},
			autoOpen:false,
			position:   { my: "center", at: "center", of: window },	
			buttons: {
				Ok: function(){
					request = $.ajax({
						type:"POST",
						url: "uploadevent.php",
						data:{
							title: $("#eventtitle").val(),
							detail: $('#eventdetail').val(),
							mergedate: $('#eventdate').val()+" "+ $("#eventtime").val(),
							mergeenddate : $('#eventenddate').val()+" "+ $('#eventendtime').val()
						}, dataType: 'json',
					   success: function(data){
							$('#calendar').fullCalendar('refetchEvents');
							alert("success");
					   }  
					});
					$(this).dialog("close");	
				},
				Cancel:function(){
				   $(this).dialog("close");
				}
			}
		});
		$("#createEvent").click(function () {
			
			$("#dialog2").dialog("open");
		});
	});
	
	



   </script>
	<!--- section for calendar -->
	<section class="bg-primary" id="cal-base">
		<div class="container-fluid" id="cal-container">
			<div class="row">
				<div class="col-lg-12  text-center" id="cal">
					<div id='calendar'></div>
					<br>
				</div>
			</div>
		</div>
	</section>
<!--	section for footer-->
	<section class="bg-primary" id="foot">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 text-center">
					<br>
					<!--script below only displays Logout button if user is not guest-->
					
					<label id= "currentuser">
						welcome! 
						
						
					</label>
	<input type='button' class="btn"  onclick="logout();" value='testloggout' /><br><br>
					<br><br>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
