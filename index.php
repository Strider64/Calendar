<?php
require_once 'lib/includes/utilities.inc.php';

use website_project\calendar\Calendar as Calendar;
use website_project\calendar\Controls as Controls;

$month = new Calendar(); // Calendar Class:
$setMonth = new Controls(); // Calendar Control:

/*
 * Grab user's input of calendar month change
 */
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
/*
 * If user didn't change month and page equals zero
 */
if (isset($page) && $page === 0) {
    $_SESSION['page'] = 0; // Current Month to Display:
}
/* Set to Previous Month or Next Month depending */
/* on what button the user clicks on .                       */
if ($page) {
    /*
     * Determine Calendar to display based on user's input
     */
    $setMonth->setMonth($page); // Set the result of the key press:
    $_SESSION['page'] = $page; // Set the current month display in sessions:
    $currentMonth = $setMonth->returnDate; // Get the result of key press:
    $month->setDate($currentMonth); // Set the current Month to display:
}
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
        <section class="container content">
            <?php
            echo $month->generateCalendar();
            echo $setMonth->returnControls;
            ?>   
        </section>
        <footer class="container footer">
            <p class="footer-name">&copy;<?php echo date("Y"); ?> <span class="spacing" itemprop="name">John R. Pepp</span> <span class="spacing" itemprop="streetAddress">9198 Woodring</span><span class="spacing" itemprop="addressLocality">Livonia</span><span class="spacing" itemprop="addressRegion">MI</span><span class="spacing" itemprop="postalCode">48150</span><span class="spacing" itemprop="telephone">(734) 748-7661</span></p>            
        </footer>
    </body>
</html>
