<?php
require_once 'lib/includes/utilities.inc.php';
if (!$trackerMember) {
    header("Location: register.php");
    exit();
}

use website_project\users\Validate;
use website_project\users\Tracker;

$validate = new Validate();
$tracker = new Tracker();

$today = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_URL);

/*
 * Check to see if it's a valid date, if not then redirect back to home page.
 */
$validDate = $tracker->phpDate($today);

if ($validDate) {
    $myDate = new DateTime($today, new DateTimeZone("America/Detroit"));
    $dateCreated = $myDate->format('Y-m-d H:i:s');
} else {
    header("Location: index.php");
    exit();
}



require_once 'lib/includes/header.inc.php';
?>

<div class="container trackerBackground">
    <aside class="span5 trackerInfo">
        <h1>Daily Fitness Tracker</h1>
        <p><?php echo $trackerMember->name; ?> monthly calendar will allow you to to keep track on how many miles you have walked in a year in a fun way. You first have to register so that you can be login, for this will enable you to keep track of you daily miles that you have walked. The Location is either where you live or where you want to start from. You will be also given a chance to pick a final destination, so my suggestion is to pick an interesting place that is not too far if you are just beginning to walk. This is in its beginning development stage, so the registration/login is currently unavailable. I hope to have this up and running soon!</p>
    </aside>
    <section class="span7">

    </section>
</div>

}
<?php
require_once 'lib/includes/footer.inc.php';
