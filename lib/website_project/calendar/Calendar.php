<?php

namespace website_project\calendar;

use DateTime;
use website_project\calendar\HolidayCheck as Holiday;
use website_project\database\Database;
use website_project\calendar\Location;

class Calendar extends Location {

    protected $date = \NULL;
    protected $page = 0;
    private $dayPos;
    private $memo = \NULL;
    public $output = \NULL;
    protected $username = \NULL;
    protected $query = \NULL;
    protected $stmt = \NULL;
    protected $urlDate = \NULL;
    protected $sendDate = \NULL;
    protected $prev = \NULL;
    protected $current = \NULL;
    protected $next = \NULL;
    protected $month = \NULL;
    protected $day = \NULL;
    protected $year = \NULL;
    protected $days = \NULL;
    protected $currentDay = \NULL;
    protected $highlightToday = \NULL;
    protected $highlightHoliday = \NULL;
    protected $isHoliday = \NULL;
    protected $prevMonth = \NULL;
    protected $nextMonth = \NULL;
    protected $selectedMonth = \NULL;
    protected $calendar = array();
    protected $theForm = \NULL;
    protected $alphaDay = [0 => "Sun", 1 => "Mon", 2 => "Tue", 3 => "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat"];
    protected $imporantDates = [];
    protected $myPage = \NULL;

    /* Constructor to create the calendar */

    public function __construct($date = NULL) {
        $this->selectedMonth = new \DateTime($date, new \DateTimeZone("America/Detroit"));
        $this->current = new \DateTime($date, new \DateTimeZone("America/Detroit"));
    }

    public function fileLocation() {
        $this->myPage = $this->returnLocation();
    }

    public function setDate($setDate) {
        $this->selectedMonth = new \DateTime($setDate, new \DateTimeZone("America/Detroit"));
        $this->current = new \DateTime($setDate, new \DateTimeZone("America/Detroit"));
    }

    public function getHolidayNames() {
        return $this->isHoliday->checkForHoliday($this->selectedMonth->format('Y-m-j'));
    }

    protected function checkForEntry() {

        $db = Database::getInstance();
        $pdo = $db->getConnection();
        $this->username = isset($_SESSION['user']) ? $_SESSION['user']->username : \NULL;
        if (!$this->username) {
            return \NULL;
        }
        $this->query = 'SELECT 1 FROM calendar WHERE date=:date AND created_by=:created_by';

        $this->stmt = $pdo->prepare($this->query);

        $this->stmt->execute([':date' => $this->urlDate, ':created_by' => $this->username]);

        $this->result = $this->stmt->fetch();

        /* If result is true there is data in day, otherwise no data */
        if ($this->result) {
            return "memo";
        } else {
            return \NULL;
        }
    }

    protected function weekdays() {
        $this->theForm .= "<tr>\n";
        $x = 1;
        while ($x <= 7) {
            if ($this->selectedMonth->format('n') === $this->current->format('n')) {
                $this->theForm .= '<td><a href="booking.php?date=' . $this->current->format('Y-m-j') . '">' . $this->current->format("j") . '</a></td>' . "\n";
            } else {
                $this->theForm .= '<td class="fade">' . $this->current->format("j") . '</td>' . "\n";
            }

            $this->current->modify("+1 day");
            $x += 1;
        }
        $this->theForm .= "</tr>\n";
    }

    protected function form() {

        $this->current->modify("first day of this month");
        $this->days = $this->current->format('t'); // Number of days in the month:
        /* Create the table */
        $this->theForm .= '<table class="span6">' . "\n";
        /* Create heading for the calendar */
        $this->theForm .= "<tr>\t\n";
        $this->theForm .= '<th class="tableHeading" colspan="7">' . $this->current->format('F Y') . '</th>' . "\t\t\n";
        $this->theForm .= "</tr>\t\n";

        /* Create days of the week heading (columns) */
        $this->theForm .= "<tr>\t\n";
        for ($x = 0; $x <= 6; $x++) {
            $this->theForm .= '<th>' . $this->alphaDay[$x] . '</th>' . "\t\t\n";
        }
        $this->theForm .= "</tr>\t\n";

        /* Generate Actual Days of the Week */
        $this->current->modify("last sun of previous month");

        $num = 1;
        while ($num < 7) {
            $this->weekdays();
            $num += 1;
        }

        /* Close the HTML tags */
        return $this->theForm .= "</table>\n";
    }

    public function getDisplayDate() {
        return $this->selectedMonth->format('l, F j, Y');
    }

    public function getTodaysDate() {
        return $this->selectedMonth->format('F j, Y');
    }

    public function get3MonthDate() {
        return $this->selectedMonth->format('M j, Y');
    }

    public function getDateMySQL() {
        return $this->selectedMonth->format('Y-m-n');
    }

    public function generateCalendar() {


        return $this->form(); // create calendar form and return it to the constructor:
    }

}
