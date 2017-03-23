function validate()
    {

		var error="";
		var name = document.getElementById( "name" );
		if( name.value == "" )
		{
		error = " You Have To Write Your Name. ";
		document.getElementById( "error_para" ).innerHTML = error;
		return false;
		}
		
		var email = document.getElementById( "email" );
		
		if( email.value == "" )
		{
		error = " You Have To Write Your Email. ";
		document.getElementById( "error_para" ).innerHTML = error;
		return false;
		}
		var format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(!email.value.match(format)){
			error = " You Have To Write Valid Email Address. ";
			document.getElementById( "error_para" ).innerHTML = error;
			return false;
		}
		

		var contact = document.getElementById( "contact" );
		if( contact.value == "" )
		{
		error = " Enter Contact number. ";
		document.getElementById( "error_para" ).innerHTML = error;
		return false;
		}
		var phoneno = /^\d{10}$/;
		if(!contact.value.match(phoneno)){
			error = " You Have To Write Valid Contact. ";
			document.getElementById( "error_para" ).innerHTML = error;
			return false;
		}
		
		var address = document.getElementById( "address" );
		if( address.value == "")
		{
		error = " Enter your Address. ";
		document.getElementById( "error_para" ).innerHTML = error;
		return false;
		}
		
		

		else
		{
		return true;
		}

    }