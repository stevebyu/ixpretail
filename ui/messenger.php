<?php if ($flash["error"]): ?>
	<div class="uk-alert uk-alert-danger" data-uk-alert>
	    <a href="" class="uk-alert-close uk-close"></a>
	    <p><?php echo $flash["error"]; ?></p>
	</div>
<?php endif; ?>

<?php if ($flash["warning"]): ?>
	<div class="uk-alert uk-alert-warning" data-uk-alert>
	    <a href="" class="uk-alert-close uk-close"></a>
	    <p><?php echo $flash["warning"]; ?></p>
	</div>
<?php endif; ?>

<?php if ($flash["message"]): ?>
	<div class="uk-alert" data-uk-alert>
	    <a href="" class="uk-alert-close uk-close"></a>
	    <p><?php echo $flash["message"]; ?></p>
	</div>
<?php endif; ?>