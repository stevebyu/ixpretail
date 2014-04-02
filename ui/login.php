<?php include 'header.php'; ?>
    			

	    			<div id="login" style="float:none;">
	    				<h2>LOG IN</h2>
						
						<?php include 'messenger.php'; ?>

	    				<form class="uk-form" id="test" action="login" method="POST">
						    <fieldset>
						    	<div class="uk-form-row">
						    		<input type="text" placeholder="username" name="username" class="uk-width-1-1" required>
						    	</div>
						    	<div class="uk-form-row">
						    		<input type="password" placeholder="password" name="password" class="uk-width-1-1" required>
						    	</div>
						         <div class="uk-form-row control-bar">
						         	<input type="submit" class="uk-button" value="Login" />
						         </div>
						    </fieldset>
						</form>
					</div>
			
				
				</div>

<?php include 'footer.php'; ?>