function checkUser() 
{  
    var min_chars = 3;  
    var characters_error = 'please enter a username to check';  
    var checking_html = '<i class="icon-spinner icon-spin icon-large"></i> checking...';  
      
    if($('#username').val().length < min_chars)
    {  
        document.getElementById('alert').removeAttribute("style")
		document.getElementById('alert').innerHTML='<span class="label label-info">Please enter a username to validate...</span>';
        document.getElementById('username_val').value = 'not valid';
        document.getElementById('username_val').className = 'btn btn-info disabled'; 
    }
    else
    {  
        document.getElementById('alert').removeAttribute("style")
		document.getElementById('alert').innerHTML='<span class="label label-info">'+checking_html+'</span>';   
        check_username_availability();  
    }          
}

function check_username_availability()
{    
    var username = $('#username').val();  
      
    $.post("/ajax/check", { username: username },  
    function(result)
    {  
        if(result == 1)
        {  
            document.getElementById('alert').removeAttribute("style")
			document.getElementById('alert').innerHTML='<span class="label label-success">'+username+' is available</span>';
			document.getElementById('username_val').value = 'valid';
			document.getElementById('username_val').className = 'btn btn-success disabled';
        }
        else
        {  
            document.getElementById('alert').removeAttribute("style")
			document.getElementById('alert').innerHTML='<span class="label label-warning">'+username+' is not available</span>';
			document.getElementById('username_val').value = 'not valid';
			document.getElementById('username_val').className = 'btn btn-danger disabled';     
        }  
    });  
}