<?php
require_once 'lib/includes/utilities.inc.php';

use website_project\users\Tracker;

$tracker = new Tracker();

$result = $tracker->delete();

if ($result) {
    header("Location: daily.php");
    exit();
}

