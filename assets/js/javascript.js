$(document).ready(function() {
	
	//sign_in.php
	$("#login_form").submit(function(e) {
		e.preventDefault();
		let valid = true;
		$('.alert').hide().removeClass('alert-danger').removeClass('alert-success').empty();
		
		var isValidInputs = checkEmpty(['email', 'password']);
		validateEmail();

		if (!isValidInputs || !validateEmail()) {
			valid = false;
		}
		
		// Submit form if valid
		if (valid) {
			$.ajax({
				type: "POST",
				url: "process_in.php",
				data: $("#login_form").serialize(),
				dataType: "json",
				success: function(response) {
					console.log(response)
					if (response.success) {
						if (response.user_type_id == 1) {
							window.location.href = "/ftn/process/donation/create.php";
						} else if (response.user_type_id == 2) {
							window.location.href = "available.php";
						} else if (response.user_type_id == 3) {
							window.location.href = "requests.php";
						}
					} else {
						$("#alert").show().addClass("alert-danger").text(response.message);
					}
				}
			});
		}
	});
	
	//forgot.php
	$("#forgot_form").submit(function(e){
		e.preventDefault();
		$(".alert").hide().removeClass("alert-success").removeClass("alert-danger").empty();
		let valid = true;

		if (!checkEmpty(['email']) || !validateEmail()) {
			valid = false;
		}
		if (valid) {
			$.ajax({
				type: 'POST',
				url: 'forgot_pwd.php',
				data: $('#forgot_form').serialize(),
				dataType: "json",
				success: function(response) {
					console.log(response)
					if (response.success) {
						$("#alert").show().removeClass("alert-danger").addClass("alert-success").html(response.message);
					} else {
						$("#alert").show().removeClass("alert-success").addClass("alert-danger").html(response.message);
					}
				}
			});
		}
	});

	//reset.php
	$("#reset_form").submit(function(e){
		e.preventDefault();
		let valid = true;
		var password = $("#password");
		var repeat_pwd = $("#repeat_pwd");

		$("#alert").hide().removeClass("alert-success").removeClass("alert-danger").empty();
		if (!checkEmpty(['password', 'repeat_pwd'])) {
		 valid = false;
		}
		if (!validatePassword(password, repeat_pwd)) {
			valid = false;
		}
		console.log(valid);

		if (valid) {
			$.ajax({
				type: 'POST',
				url: 'reset_pwd.php',
				data: $("#reset_form").serialize(),
				dataType: "json",
				success: function(response) {
					console.log(response)
					if (response.success) {
						$("#alert").show().removeClass("alert-danger").addClass("alert-success").html(response.message);
						setTimeout(function(){
							window.location.href = "/ftn/process/ac/sign_in.php";
						}, 3000);
					} else {
						$("#alert").show().removeClass("alert-success").addClass("alert-danger").html(response.message);
					}
				}
			});
		}
	});
	
	// fucntion to check empty
	function checkEmpty(inputIds) {
		var isValid = true;
		inputIds.forEach(function(id) {
			var input = $("#" + id);
			if(input.val() == "" || input.val() == null || input.val() == "-"){
				input.addClass("is-invalid");
				$("#" + id + "-error").html('Required!');
				isValid = false;
			}	else {
					input.removeClass("is-invalid");
					$("#" + id + "-error").html("");
					isValid = true;
			}
		});
		return isValid;
	}
	// Function to validate email
	function validateEmail() {
		var email = $('input[type="email"]');
		var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!email.hasClass("is-invalid")) {
			if(!regex.test(email.val())){
				email.addClass("is-invalid");
				$("#email-error").html("Pleaes enter a valid email address");
				return false;
			} else {
				email.removeClass("is-invalid");
				$("#email-error").html("");
				return true;
			}
		} else {
			return false;
		}
	}

	//Function to validate password
	function validatePassword(password, repeat_pwd) {
		if (!password.hasClass("is-invalid")) {
			if (password.val().length < 6) {
				password.addClass("is-invalid");
				$("#password-error").html("Password must be at least 6 characters long");
				return false;
			} else {
				password.removeClass("is-invalid");
				$("#password-error").html("");
				if (!repeat_pwd.hasClass("is-invalid")) {
					if (password.val() != repeat_pwd.val()) {
						repeat_pwd.addClass("is-invalid");
						$("#repeat_pwd-error").html("Password and confirm password do not match");
						return false;
					} else {
							return true;
					}
				}
			}
		} else {
				return false;
		}
	}
});