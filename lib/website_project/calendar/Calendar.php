<?php

namespace website_project\calendar;

use DateTime;
use website_project\calendar\HolidayCheck as Holiday;
use website_project\database\Database;
use website_project\calendar\Location;

class Calendar extends Location {

    protected $date = \NULL;
    protected $page = 0;
    public $output = \NULL;
    protected $username = \NULL;
    protected $query = \NULL;
    protected $stmt = \NULL;
    protected $urlDate = \NULL;
    protected $sendDate = \NULL;
    protected $prev = \NULL;
    public $current = \NULL;
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
    public $selectedMonth = \NULL;
    public $n = \NULL;
    protected $calendar = array();
    protected $theForm = \NULL;
    protected $alphaDay = [0 => "Sun", 1 => "Mon", 2 => "Tue", 3 => "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat"];
    protected $imporantDates = [];
    protected $myPage = \NULL;
    protected $size = \NULL;
    protected $now = \NULL;
    protected $monthlyChange = \NULL;

    /* Constructor to create the calendar */

    public function __construct($date = null, $size = 100) {
        $this->selectedMonth = new \DateTime($date, new \DateTimeZone("America/Detroit"));
        $this->current = new \DateTime($date, new \DateTimeZone("America/Detroit"));
        $this->current->modify("first day of this month");
        $this->n = $this->current->format("n");
        $this->size = $size;
    }

    public function fileLocation() {
        return $this->returnLocation();
    }

    public function checkIsAValidDate($myDateString) {
        return (bool) strtotime($myDateString);
    }

    public function phpDate($size = 100) {
        $setDate = filter_input(INPUT_GET, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $valid = $this->checkIsAValidDate($setDate);
        if (isset($setDate) && strlen($setDate) === 10 && $valid) {
            self::__construct($setDate, $size);
        }
    }

    public function returnDate() {
        return $this->selectedMonth;
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

    /* Highlight Today's Date on Calendar */

    protected function currentDays() {
        if ($this->now->format("F j, Y") === $this->current->format("F j, Y")) {
            $this->theForm .= "\t\t" . '<td class="eggplant"><a class="sand" href="daily.php?date=' . $this->current->format('Y-m-j') . '">' . $this->current->format("j") . '</a></td>' . "\n";
        } else {
            $this->theForm .= "\t\t" . '<td><a href="daily.php?date=' . $this->current->format('Y-m-j') . '">' . $this->current->format("j") . '</a></td>' . "\n";
        }
    }

    /* Draw Days (make Table Cells) on Calendar */

    protected function drawDays() {

        $this->now = new \DateTime("Now", new \DateTimeZone("America/Detroit"));
        $this->theForm .= "\t<tr>\n";
        $x = 1;
        while ($x <= 7) {
            if ($this->selectedMonth->format('n') === $this->current->format('n')) {
                $this->currentDays();
            } else {
                $this->theForm .= "\t\t" . '<td class="fade">' . $this->current->format("j") . '</td>' . "\n";
            }

            $this->current->modify("+1 day");
            $x += 1;
        }
        $this->theForm .= "\t</tr>\n";
    }

    protected function heading() {
        $this->monthlyChange = new DateTime($this->current->format("F j, Y"));
        $this->monthlyChange->modify("-1 month");
        $this->prev = $this->monthlyChange->format("Y-m-d");
        $this->monthlyChange->modify("+2 month");
        $this->next = $this->monthlyChange->format("Y-m-d");
        /* Create heading for the calendar */
        $this->theForm .= "\t<tr>\n";
        $this->theForm .= "\t\t" . '<th class="tableHeading" colspan="7">';
        $this->theForm .= '<a data-pos="prev" class="prev-left" href="' . $this->fileLocation() . '?location=' . $this->prev . '">Prev</a>';
        $this->theForm .= $this->current->format('F Y');
        $this->theForm .= '<a data-pos="next" class="next-right" href="' . $this->fileLocation() . '?location=' . $this->next . '">Next</a>';
        $this->theForm .= "</th>\n";
        $this->theForm .= "\t</tr>\n";
    }

    protected function display() {
        $this->days = $this->current->format('t'); // Number of days in the month:
        /* Create the table */
        $this->theForm .= '<table>' . "\n";
        $this->heading();
        /* Create days of the week heading (columns) */
        $this->theForm .= "\t<tr>\n";
        for ($x = 0; $x <= 6; $x++) {
            $this->theForm .= "\t\t<th>" . $this->alphaDay[$x] . "</th>\n";
        }
        $this->theForm .= "\t</tr>\n";

        /* Generate Actual Days of the Week */
        $this->current->modify("last sun of previous month");

        /*
         * Output 7 rows (49 days) guarantees an even calendar.
         */
        $num = 1;
        while ($num < 7) {
            $this->drawDays();
            $num += 1;
        }

        /* Close the HTML tags */
        return $this->theForm .= "</table>\n";
    }

    public function generateCalendar() {
        return $this->display();
    }

}
