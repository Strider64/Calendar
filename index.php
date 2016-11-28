<?php
require_once 'lib/includes/utilities.inc.php';

use website_project\calendar\Calendar as Calendar;
use website_project\calendar\Controls as Controls;

$month = new Calendar(); // Calendar Class:

$displayDate = $month->changeDate(); // Change month to previous or next month if user clicks on the links:

$month->setDate($displayDate);
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
        <title>Calendar</title>
        <link rel="stylesheet" href="lib/css/stylesheet.css">
    </head>
    <body>
        <header class="container header">
            <h1 class="heading">Burroughs Farms Calendar</h1>
        </header>
        <div class="container">

            <section class="span6 content">
                <?php
                echo $month->generateCalendar();
                ?> 
            </section>

            <div class="span6 picture">`
                <figure class="imageCalendar">
                    <img class="current" src="lib/user_uploads/img-burroughs-farms-<?php echo $month->n; ?>.jpg">
                </figure>
            </div>

        </div>
        <footer class="container footer">
            <p class="footer-name">&copy;<?php echo date("Y"); ?> <span class="spacing" itemprop="name">John R. Pepp</span> <span class="spacing" itemprop="streetAddress">9198 Woodring</span><span class="spacing" itemprop="addressLocality">Livonia</span><span class="spacing" itemprop="addressRegion">MI</span><span class="spacing" itemprop="postalCode">48150</span><span class="spacing" itemprop="telephone">(734) 748-7661</span></p>            
        </footer>
    </body>
</html>