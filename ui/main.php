<?php include 'header.php'; ?>

    			<?php 
    			if($_SESSION['user']['admin']){
    				include 'admin/dashboard.php';
    			} else {
    				include 'dashboard.php'; 
    			}
    			?>

<?php include 'footer.php'; ?>