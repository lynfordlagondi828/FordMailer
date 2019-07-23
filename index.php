<?php
	require_once 'class/Db_Functions.php';
	$database = new Db_Functions();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Mailing</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
</head>
<body>
	<div class="container" style="margin-top: 40px;"> 

	  <div class="row">
	  	  <div class="col-md-60 col-md-offset-0">
	  	  	<p id="response">
	  	  		
	  	  	</p>
	  	  	<table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
	  	  		<thead>
	  	  			<tr>
	  	  				<td>Name</td>
	  	  				<td>Email</td>
	  	  				<td>
	  	  					<input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);" /> Check All</div>
                            </td>
	  	  				</td>
	  	  			</tr>
	  	  		</thead>
	  	  		<tbody>
	  	  		</tbody>
                  
                  
	  	  	</table>
            <input style="float: right" type="button" onclick="sent_to()" class="btn btn-danger" id="display_send_email" value="Send">
	  	  	
	  	  
	  	  </div>
	  </div>
	</div>


 	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
    	$(document).ready(function(){
    		fetchCustomer(0, 10);

            $("#closeBtn").fadeIn();
    	});

    	function fetchCustomer(start,limit){
    		
    		$.ajax({

    			url:'ajax.php',
    			method: 'POST',
    			dataType:'text',
    			data:{
    				key:'get_email',
    				start:start,
    				limit:limit
    			},success: function(response){
    				if (response != "reachedMax") {

    					$('tbody').append(response);
    					start += limit;
    					fetchCustomer(start,limit);

    				} else {

    					$('.table').DataTable();
    				}
    			}
    		});
    	}

		//Select email
    	function check_uncheck_checkbox(isChecked){
			//alert(document.getElementsByName('single_select[]').length);
			var to_send="";
			for(var i=0;i<document.getElementsByName('single_select[]').length;i++){
				//alert(document.getElementsByName('emails[]')[i].value);
				
			}
			//alert(to_send);
			//document.getElementById('customer_email').value = to_send;
			if(isChecked) {
                $('input[name="single_select[]"]').each(function() { 
                    this.checked = true; 
                });
            } else {

            	$('input[name="single_select[]"]').each(function() {
                    this.checked = false;
                });
            }
    	}

    	/**
        * Send email by selected checkbox
         */
        function sent_to(){

            var email_data = [];
			var to_send="";
            $('.single_select').each(function(){
				if($(this).prop("checked") == true)
				{
					/*email_data.push({
						customer_email: $(this).data('customer_email'),
						customer_name: $(this).data("customer_name")
					});*/
					//alert($(this).data('customer_email'));
					if(to_send!="")
					to_send+=";";

					to_send+=$(this).data('customer_email');
					
				} 
                
			});
			//alert(to_send);
            var selected="";
            selected = to_send;

            if(selected!="") {
                
                $("#display_send_email").on('click',function(){
                $("#tableManager").modal('show');
                });

                $("#customer_email").val(to_send);

            }else{
                alert("Ooops!!Please select email address in the checkbox.");	
            }
        }

		//Send Email Now
		function send_email_now(key){
			var emails = document.getElementById('customer_email').value;
			emails = emails.split(";");
            var message = $("#message").val();
			$.ajax({
				
				url:'ajax.php',
				method:'POST',
				dataType:'text',
				data:{
					key:'send_email',
					emails: emails,
                    message: message
				},success: function(response){
					alert(response);
				}
			});
		}

	</script>
	<div id="tableManager" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Compose Email</h2>
                    </div>

                    <div class="modal-body">
                        <div id="editContent">
                        <input class="form-control" type="text" id="customer_email" placeholder="Email" required>
                        <br>
                        <textarea class="form-control" type="text" rows="8" cols="40" id="message" placeholder="Message" required></textarea><br>
                        
                        <input class="form-control" type="hidden" id="editRowID" value="0">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="button" class="btn btn-primary" data-dismiss="modal" value="Close" id="closeBtn" style="display: none;">
                        <input type="button" id="manageBtn" onclick="send_email_now('confirm')" value="Send Now" class="btn btn-success">
                    </div>
                </div>
            </div>
        </div>
</body>
</html>