//validates for required fields.
$('#add_topic').ready(function() 
{
	//validate
	$("#addTopic").validate({
		rules:{
			subject:"required"
			},
				
		messages: {
			subject: "Please enter some content"
		}
	});
       
    //when button is clicked  
    $('#add_topic').click(function()
    { 
         //run the character number check  
         if($('#subject').val().length > 0 && $('#categoryID').val().length > 0)
         {  
             addTopic();   
         }
         else
         {
	         document.getElementById('alert').removeAttribute("style");
			 document.getElementById('alert').innerHTML='<span class="label label-warning">please correct the errors...</span>';
         }  
     });  
});  

//function to add new topic
function addTopic()
{    
    //get data  
    var subject = $('#subject').val();
    var category =  $('#categoryID').val();
       
    $.post("/ajax/topic/add", { subject: subject, category: category },  
        function(result)
        {  
            if(result == 1)
            {  
                //topic added
                document.getElementById('alert').removeAttribute("style")
                document.getElementById('alert').innerHTML='<span class="label label-success">new topic added</span>';
				setTimeout("location.reload(true);",3000);
            }
            else
            {  
                //topic not added
                document.getElementById('alert').removeAttribute("style")
                document.getElementById('alert').innerHTML='<span class="label label-warning">there was an error!</span>';
                //setTimeout("location.reload(true);",3000);  
            }  
    });  
      
}