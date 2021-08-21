//validates for required fields.
$('#add_post').ready(function() 
{
	//validate
	$("#addPost").validate({
		rules:{
			content:"required"
			},
				
		messages: {
			content: "Please enter some content"
		}
		  
	});
       
    //when button is clicked  
    $('#add_post').click(function()
    { 
         //run the character number check  
         if($('#content').val().length > 0 && $('#topicID').val().length > 0)
         {  
             addPost();   
         }
         else
         {
	         document.getElementById('alert').removeAttribute("style");
			 document.getElementById('alert').innerHTML='<span class="label label-warning">please correct the errors...</span>';
         }  
     });  
});  

//function to add new post  
function addPost()
{    
    //get data  
    var content = $('#content').val();
    var topic =  $('#topicID').val();
      
    $.post("/ajax/post/add", { content: content, topic: topic },  
        function(result)
        {  
            if(result == 1)
            {  
                //post added
                document.getElementById('alert').removeAttribute("style")
                document.getElementById('alert').innerHTML='<span class="label label-success">new post added</span>';
				setTimeout("location.reload(true);",3000);
            }
            else
            {  
                //post not added
                document.getElementById('alert').removeAttribute("style")
                document.getElementById('alert').innerHTML='<span class="label label-warning">there was an error!</span>';
                setTimeout("location.reload(true);",3000);  
            }  
    });  
      
}