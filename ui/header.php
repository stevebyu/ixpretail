<!DOCTYPE html

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="ui/css/uikit.css" />
        <!--<link rel="stylesheet" href="ui/css/uikit.almost-flat.min.css" />-->
        <link rel="stylesheet" href="ui/css/datepicker.almost-flat.min.css" />
        <link rel="stylesheet" href="ui/css/ixp.css" />
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="ui/js/uikit.min.js"></script>
        <script src="ui/js/datepicker.min.js"></script>
        <script src="ui/js/ixp.js"></script>
        <script src="ui/js/jquery.dataTables.min.js"></script>
    </head>
    <head>
    <body>
    	<header class="main">
    		<div class="wrapper">
	    		<img class="logo" src="ui/images/logo.jpg" />

                <?php if (isset($_SESSION['user'])): ?>
                   <nav class="main">
                        <ul class="uk-subnav uk-subnav-pill">

                        <?php if ($_SESSION['user']['admin']): ?>
                            
                            <li class="uk-active"><a href="admin/dashboard"><i class="uk-icon-dashboard"></i> Dashboard</a></li>
                            <li><a href="admin/report"><i class="uk-icon-table"></i> Reports</a></li>
                            <li><a href="admin/manage"><i class="uk-icon-cog"></i> Manage</a></li>

                        <?php else: ?>
                            
                            <li class="uk-active"><a href="dashboard"><i class="uk-icon-dashboard"></i> Dashboard</a></li>
                            <li><a href="settings"><i class="uk-icon-cog"></i> Settings</a></li>

                        <?php endif; ?>
                            

                            <li class="no-select username" data-uk-dropdown="{mode:'click','hover'}">
                                <a href="account"><span id="userWelcome"><?php echo $_SESSION['user']['username'] ?></span> <i class="uk-icon-caret-down"></i></a>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav uk-nav-dropdown">
                                        <li><a href="account"><i class="uk-icon-user"></i> My Account</a></li>
                                        <li><a href="logout"><i class="uk-icon-sign-out"></i> Log out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

			</div>
    	</header>
    	<section class="main">
    		<div id="mainContent" class="wrapper">