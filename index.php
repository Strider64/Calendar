<?php
require_once 'lib/includes/utilities.inc.php';

use website_project\calendar\Calendar as Calendar;

$month = new Calendar(); // Calendar Class:

$month->phpDate();

include 'lib/includes/header.inc.php';
?>
<div id="home" class="container">
    <aside class="m-span7 sidebar">
        <figure class="pictureBox">
            <img class="picture" src="lib/monthly_images/img-month-<?php echo $month->n; ?>.png">
        </figure>
        <?php echo $month->generateCalendar(); ?>
    </aside>
    <section class="m-span5 websiteInfo">
        <div class="tablet">
            <h1>Burroughs Farms</h1>
            <h3>An Online Calendar</h3>
            <hr>
            <p>Over the next couple of weeks I am going to be updating this calendar and I am planning adding a feature where you can contribute pictures to the calendar. It's going to take me some time to write the upload script and I will be generating a username and password so that only approved people can contribute pictures. I'm trying to figure out how to give that information without everyone on FB seeing it. Though I'm not there yet, so I won't worry about that until I am. I have changed the color theme of this website and I will be adding a better header in the next couple of days. More updates to follow in the upcoming weeks.
</p>
        </div>
    </section>
</div>   
<?php
require_once 'lib/includes/footer.inc.php';
