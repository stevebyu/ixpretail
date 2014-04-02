<script type="text/javascript">

	$("#btnSaveAccount").click(function(){
		var form = $(this).closest("form");
			//call update
			$.ajax({
				url:"/api/users/" + user.id,
				method: "PUT",
				data:form.serializeObject(),
				success:function(data){
					console.log(data);
					if(data){
						$(window).trigger("hashchange");
					}
				}
			});
	});


</script>

		<form class="uk-form uk-panel uk-panel-box" style="width: 300px; margin: auto; float: none;" id="accountForm">
		    <fieldset>
		        <legend>My Account</legend>
		        <?php include 'messenger.php' ?>
		        <div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="Username" name="username" required></div>
		        <div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="First Name" name="first_name" required></div>
		        <div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="Last Name" name="last_name" required></div>
		        <div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="Email" name="email"></div>
		        <div class="uk-form-row"><input type="password" class="uk-width-1-1" placeholder="Password" name="password"></div>
		        <div class="uk-form-row"><input type="password" class="uk-width-1-1"placeholder="Confirm Password"></div>
		        <div class="uk-form-row control-bar"><button type="submit" formnovalidate class="uk-button" id="btnSaveAccount"><i class="uk-icon-save"></i></button></div>
		    </fieldset>
		</form>