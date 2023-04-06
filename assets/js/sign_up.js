//district and area drop down
$(document).ready(function() {
	console.log('document is ready');
	$('.area-option').hide();
	$('#district').change(function() {
		console.log('district select changed');
		var district_id = $(this).val();
		$('#area').val(''); // reset the value of the "area" select box
		$('.area-option').not('.district-' + district_id).hide();
		$('.district-' + district_id).show();
	});
});

//change form and elements based on the user type selected
// Get the user_type element
var user_type = $("#user_type");

// Get the div elements
var default_div = $("#default");
var common_div = $("#common_fields");
var donor_div = $("#donor_fields")
var beneficiary_div = $("#beneficiary_fields");
var	volunteer_div = $("#volunteer_fields");
var db_div = $('#db_fields');
var dv_div = $('#dv_fields');

// Hide the common_fields div initially
common_div.hide();

// Add a change event listener to the user_type element
user_type.on("change", function() {
	$('#alert').hide().removeClass('alert-danger').removeClass('alert-success').empty();
	// Check if the default option is selected
	if (user_type.val() === "") {
		// Show the default div and hide the common_fields div
		default_div.toggle(true);
		common_div.toggle(false);
	} else {
		// Hide the default div and show the common_fields div
		default_div.toggle(false);
		common_div.toggle(true);

		if (user_type.val() ==="1") {
			$('#h2').text('Register your business');
			$('#name_label').text('Name of your business');
			donor_div.toggle(true);
			beneficiary_div.toggle(false);
			volunteer_div.toggle(false);
			db_div.toggle(true);
			dv_div.toggle(true);
			$('#operating_dh').text('Workdays and office hours');
			$('#label_st').text('Opening time');
			$('#label_et').text('Closing time');
		} else if (user_type.val() ==="2") {
			$('#h2').text('Register your charity organization');
			$('#name_label').text('Name of your charity organization');
			donor_div.toggle(false);
			beneficiary_div.toggle(true);
			volunteer_div.toggle(false);
			db_div.toggle(true);
			dv_div.toggle(false);
		} else {
			$('#h2').text('Register yourself as volunteer member');
			$('#name_label').text('Enter your name');
			donor_div.toggle(false);
			beneficiary_div.toggle(false);
			volunteer_div.toggle(true);
			db_div.toggle(false);
			dv_div.toggle(true);
			$('#operating_dh').text('What days and hours are you willing to volunteer?');
			$('#label_st').text('From');
			$('#label_et').text('To');
		}
	}
});

$("#submit_btn").click(function(e) {
	e.preventDefault(); //prevent default form submission
	var valid = true; //flag to check if all fields are valid
	var all_fields = $("#common_fields").find("input, select"); //get all input and select elements in common_fields div
	var common_fields = all_fields.not("#donor_fields select, #beneficiary_fields select, #db_fields input, #volunteer_fields select, #dv_fields input"); // Exclude those elements those not common
	var donor_fields = $("#donor_fields").find("select"); //get all select elements in donor_fields div
	var beneficiary_fields = $("#beneficiary_fields").find("select"); //get all select elements in beneficiary_fields div
	var volunteer_fields = $("#volunteer_fields").find("select"); //get all select elements in volunteer_fields div
	var db_fields = $("#db_fields").find("input"); //get all input elements in db_fields div
	var dv_fields = $("#dv_fields").find("input"); //get all input elements in dv_fields div

	$('#alert').hide().removeClass('alert-danger').removeClass('alert-success').empty();

	//reset the form if the user_type has changed
	$(user_type).change(function() {
		valid = true;
		$("#reg_form input, #reg_form select").removeClass("alert alert-danger errorch");
		$('[id$="_error"]').hide();
	});

	//function to check if a field is empty or not selected
	function checkEmpty(field) {
		if (field.val() == "" || field.val() == null || field.val() == "-") {
			field.addClass("alert alert-danger"); //add alert alert-danger class to highlight the field
			valid = false; //set valid flag to false
		} else {
			field.removeClass("alert alert-danger"); //remove alert alert-danger class if field is not empty or selected
		}
	}
	
	//function to validate phone number based on Sri Lankan scenario using regex
	function validatePhoneInput(phoneInput) {
		var phone = phoneInput.val();
		var regex = /^(94|0)[1-9][0-9]{8}$|^[1-9][0-9]{8}$/;
		if (!regex.test(phone)) {
			phoneInput.addClass("alert alert-danger");
			document.getElementById(phoneInput.attr('id') + "_error").style.display = "block";
			return false;
		} else {
			phoneInput.removeClass("alert alert-danger");
			document.getElementById(phoneInput.attr('id') + "_error").style.display = "none";
			return true;
		}
	}

	//function to validate email address using regex
	function validateEmail(email) {
		var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return regex.test(email);
	}

	//function to check if a time input is valid or not using regex
	function checkTime(time) {
		var regex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
		if (!regex.test(time.val())) {
			time.addClass("alert alert-danger"); //add alert alert-danger class to highlight the field
			valid = false; //set valid flag to false
		} else {
			time.removeClass("alert alert-danger"); //remove alert alert-danger class if time is valid
		}
	}

	function validateDVFields(dv_fields) {
		// Loop through each dv_field
		dv_fields.each(function() {
			var field = $(this); //get current element 
			var type = field.attr("type"); //get type attribute of current element 

			if (type == "checkbox") { //if current element is a checkbox 
				var checked = false; //flag to check if any checkbox is checked 
				$("input[name='days[]']").each(function() { //loop through all checkboxes with name attribute of days[] 
					if ($(this).is(":checked")) { //if current checkbox is checked 
						checked = true; //set checked flag to true 
					}
				});

				if (!checked) { //if no checkbox is checked 
						field.addClass("errorch"); //add errorch class to highlight the field 
						valid = false; //set valid flag to false
				} else {
						field.removeClass("errorch"); //remove errorch class if any checkbox is checked
				}
						
			} else if (type == "time") { //if current element is a time input 
					checkTime(field); //call checkTime function with current element as argument
			} else { //if current element is any other type of input
					checkEmpty(field); //call checkEmpty function with current element as argument
			}
		});
	}

	//loop through common_fields elements and check if they are empty or not selected
	common_fields.each(function() {
		checkEmpty($(this)); //call checkEmpty function with current element as argument
	});
	
	valid = validatePhoneInput($("#contact_no")) && valid;

	//check if email field is valid using validateEmail function
	var email = $("#email");
	if (!validateEmail(email.val())) {
		email.addClass("alert alert-danger");
		document.getElementById("email_error").style.display = "block";
		valid = false; //set valid flag to false
	} else {
		email.removeClass("alert alert-danger");
		document.getElementById("email_error").style.display = "none";
	}

	//check if password and confirm password fields match
	var password = $("#password");
	var confirm_password = $("#repeat_pwd");
	if (password.val().length < 6) {
		password.addClass("alert alert-danger"); //add alert alert-danger class to highlight the field
		$("#password_error").show(); //show the password_error div
		valid = false; //set valid flag to false
	} else {
		password.removeClass("alert alert-danger"); //remove alert alert-danger class if passwords match
		$("#password_error").hide(); //hide the password_error div
		if (password.val() != confirm_password.val()) {
			confirm_password.addClass("alert alert-danger"); //add alert alert-danger class to highlight the field
			$("#repeat_pwd_error").show(); //show the repeat_pwd_error div
			valid = false; //set valid flag to false
		} else {
			confirm_password.removeClass("alert alert-danger"); //remove alert alert-danger class if passwords match
			$("#repeat_pwd_error").hide();
		}
	}
	
	//check if user_type is business
	if (user_type.val() === "1") {
		//loop through donor_fields elements and check if they are not selected
		donor_fields.each(function() {
			checkEmpty($(this)); //call checkEmpty function with current element as argument
		});

		//loop through db_fields elements and check if they are empty
		db_fields.each(function() {
			checkEmpty($(this)); //call checkEmpty function with current element as argument
		});

		//check if cp_phone field is valid using validatePhone function
		valid = validatePhoneInput($("#cp_phone")) && valid;
		validateDVFields(dv_fields);
	}

	//check if user_type is charity
	if (user_type.val() === "2") {
		//loop through beneficiary_fields elements and check if they are not selected
		beneficiary_fields.each(function() {
			checkEmpty($(this)); //call checkEmpty function with current element as argument
		});

		//loop through db_fields elements and check if they are empty
		db_fields.each(function() {
			checkEmpty($(this)); //call checkEmpty function with current element as argument
		});

		//check if cp_phone field is valid using validatePhone function
		valid = validatePhoneInput($("#cp_phone")) && valid;
	}

	//check if user_type is volunteer
	if (user_type.val() === "3") {
		//loop through volunteer_fields elements and check if they are not selected
		volunteer_fields.each(function() {
			checkEmpty($(this)); //call checkEmpty function with current element as argument
		});
		validateDVFields(dv_fields);
	}

	//if all fields are valid
	if (valid) { //if all fields are valid
		$("#reg_form").submit(); //submit the form
	}
});

$(document).ready(function() {
	$("#reg_form").submit(function(event) {
		event.preventDefault();

		// Get the form data
		var formData = $(this).serialize();

		// Send the form data using AJAX
		$.ajax({
			url: "process_up.php",
			type: "POST",
			data: formData,
			dataType: "json",
			success: function(response) {
				if (response.success) {
					// If the form was submitted successfully, show the success message
					$("#alert").show().removeClass("alert-danger").addClass("alert-success").text(response.message);
					$('#reg_form')[0].reset();
					default_div.toggle(true);
					common_div.toggle(false);
				} else {
						// If there was an error, show the error message
						$("#alert").show().removeClass("alert-success").addClass("alert-danger").text(response.message);
				}
			}
		});
	});
});