<?php

namespace website_project\calendar;

use DateTime;
use website_project\calendar\Location;
use website_project\database\MyPDO;

class Controls extends Location {

    public $returnDate;
    public $displayControls;
    public $returnControls;
    protected static $todaysDate;
    protected static $page;
    protected static $varPage;
    protected static $next;
    protected static $previous;
    protected $urlDate;
    protected $currentMonthPositon;
    protected $myPage = \NULL;

    public function __construct($page = 0) {
        date_default_timezone_set('America/Detroit');
        $this->returnDate = $this->todaysDate($page);
        $this->returnControls = $this->calButtons();
    }

    public function fileLocation() {
        $this->myPage = $this->returnLocation();
    }

    /* Set the month to display for the calendar */
    public function setMonth($page) {
        return self::__construct($page);
    }

    public function currentMonthPosition($calendarDate, $numOfMonths) {
        $this->urlDate = date('Y-m-d', strtotime($calendarDate . '+' . $numOfMonths . ' months'));
        return $this->currentMonthPositon = date('F j, Y', strtotime($calendarDate . ' +' . $numOfMonths . ' months'));
    }

    /* Determine the previous Month or next Month method(function) */
    protected function todaysDate($page) {

        self::$todaysDate = date('F Y'); // Today's Month && Year (minus the day giving 1st of the month):
        self::$page = isset($page) ? $page : NULL;

        self::$varPage = isset(self::$page) ? self::$page : 0;

        self::$previous = isset(self::$page) ? self::$page - 1 : -1; // Previous Month Button Press:
        self::$next = isset(self::$page) ? self::$page + 1 : 1; // Next Month Button Press:

        return $this->currentMonthPosition(self::$todaysDate, self::$varPage); // Set the month to display method(function):
    }

    protected function calButtons() {
        $this->displayControls = '<div class="controls">' . PHP_EOL;
        $this->displayControls .= '<a data-pos="' . self::$previous . '" class="pic-slide-left fa fa-angle-double-left" href="' . $this->myPage . '?page=' . self::$previous  .' ">&nbsp;</a>' . PHP_EOL;
        $this->displayControls .= '<a data-pos="' . self::$next . '" class="pic-slide-right fa fa-angle-double-right" href=" ' . $this->myPage . '?page=' . self::$next . '">&nbsp;</a>' . PHP_EOL;
        $this->displayControls .= '</div>' . PHP_EOL;
        return $this->displayControls;
    }

}
