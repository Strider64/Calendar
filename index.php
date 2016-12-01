<?php
require_once 'lib/includes/utilities.inc.php';

use website_project\calendar\Calendar as Calendar;

$month = new Calendar(); // Calendar Class:

$month->phpDate();
?>

<!DOCTYPE html>
<!--
Pepster's Place 
A Website Design & Development Company
President John R Pepp
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <title>Calendar</title>
        <link rel="stylesheet" href="lib/css/stylesheet.css">
    </head>
    <body>
        <header class="container header">
            <h1 class="heading">Burroughs Farms Calendar</h1>
        </header>
        <div class="container">


            <figure class="imageCalendar">
                <img class="current" src="lib/user_uploads/img-burroughs-farms-<?php echo $month->n; ?>.jpg">
            </figure>



            <?php
            echo $month->generateCalendar();
            ?> 

        </div>
        <footer class="container footer">
            <p class="footer-name">&copy;<?php echo date("Y"); ?> <span class="spacing" itemprop="name">Pepster's Place</span></span></p>            
        </footer>
    </body>
</html>