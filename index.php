<?php
session_start();
if (!empty($_COOKIE['usrtkn']) && !empty($_COOKIE['tknpass']) && !empty($_SESSION['dashbord'])){ ?>
<!DOCTYPE html>
    <html lang="en" dir="ltr">
        <title>Billing System-Login</title>
    <head><meta name="viewport" content="width=device-width, initial-scale=1"></head>
        <script type="text/javascript" src="script.js"></script>
        <link rel="stylesheet" type="text/css" href="wholestyle.css"/>
        <body>
            <div id="loading-overlay"><div class="loading-icon"></div></div>
            <div id ="mainsysscr">
                <div class='headerinfo'><h1>Landway Engineering - Billing System</h1><p align='center' id='clock'></p></div>
                <div id="targetscreen" class="optdisplayscr"><h1 style='color:green; text-align:center; margin-top:300px;'>Welcome</h1></div>
                <div class="dashbddiv"><?php echo $_SESSION['dashbord']; ?></div>
            </div>
        </body>
    <script type="text/javascript" src="adminsys.code.js"></script>
    </html><?php }else{?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <title>Billing System - Landway Engineering</title>
<head><meta name="viewport" content="width=device-width, initial-scale=1"></head>
    <script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="wholestyle.css"/>
	<body>
        <div id ="mainsysscrlogin">
            <div id="loading-overlay"><div class="loading-icon"></div></div>
            <form method="post" autocomplete="off" onsubmit="return false">
                <h1>Billing System User Login</h1>
                <table>
                    <tr>
                        <td>User</td>
                        <td><input type="text" id="lwelguser"/></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="password" id="lwelgpass"/></td>
                    </tr>
                </table>
                <input type="submit" value="Login" id="lwelgsubmit"/>
            </form>
        </div>
	</body>
<script type="text/javascript" src="adminsys.code.js"></script>
</html><?php } ?>