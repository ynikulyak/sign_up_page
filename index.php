<!DOCTYPE html>
<html>
<head>
	<title>Sign Up Page</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body>
	<h1>Sign Up</h1>
	<form method="post" action="welcome.php">
	First Name: <input type="text" name="fname"><br>
	Last Name: <input type="text" name="lname"><br>
	Gender: <input type="radio" name="gender" value="m"> Male
			<input type="radio" name="gender" value="f"> Female<br><br>

	Zip Code: <input type="text" name="zip" id="zip"><br>
	City: <span id="city"></span><br>
	Latitude: <span id="latitude"></span> <br>
	Longitude: <span id="longt"></span> <br><br>
	State:
	<select id="state" name="state">
		<option value="">Select One</option>
		<option value="ca">California</option>
		<option value="ny">New York</option>
		<option value="tx">Texas</option>
	</select><br>

	Select a county: <select id="county"></select><br><br>

	Desired Username: <input type="text" name="username" id="username"><span id="usernameError"></span><br>
	Password: <input type="password" name="password" id="password"><br>
		Password Again: <input type="password" id="passwordAgain"><span id="passwordAgainError"></span><br>
	<input type="submit" value="Sign up!">
	</form>
	<script>
		var usernameAvailable = false;
		$("#zip").on("change", function(){
			//alert( $("#zip").val() ); 
			$.ajax({
				method: "GET",
				url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
				dataType: "json",
				data: {"zip": $("#zip").val()},
				success: function(result, status){
					//alert(result.city);
					$("#city").html(result.city);
					$("#latitude").html(result.latitude);
					$("#longt").html(result.longitude);
				}
			});
		});
		
		$("#state").on("change", function(){
			//alert($("#state").val());
			$.ajax({
				method: "GET",
				url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
				dataType: "json",
				data: {"state": $("#state").val()},
				success: function(result, status){
					//alert(result[0].county);
					$("#county").html("<option> Select One </option>");
					for(let i = 0; i < result.length; i++){
						$("#county").append("<option>" + result[i].county + "</option>");
					}
				}
			});
		});
		
		$("#username").change(function(){
			//alert($("#username").val());
		$.ajax({
			method: "GET",
			url: "https://cst336.herokuapp.com/projects/api/usernamesAPI.php",
			dataType: "json",
			data: {"username": $("#username").val()},
			success: function(result, status){

				if(result.available){
					$("#usernameError").html("Username is available");
					$("#usernameError").css("color", "green");
					usernameAvailable = true;
				}
				else{
					$("#usernameError").html("Username is unavailable");
					$("#usernameError").css("color", "red");
					usernameAvailable = false;
				}
			}
		});
	});
		
		$("#signupForm").on("submit", function(event){
			if(!isFormValid()){
				event.preventDefault();
			}
		});
		
		function isFormValid(){
			var isValid = true;
			if(!usernameAvailable){
				isValid = false;
			}
			if($("#username").val().length == 0){
				$("#usernameError").html("Username is required!");
				isValid = false;
			}
			if($("#password").val() != $("passwordAgain").val()){
				$("#passwordAgainError").html("Password mismatch!");
				isValid = false;
			}
			return isValid;
		}
	</script>
</body>
</html>
