<?php

namespace website_project\calendar;

use DateTime;

class HolidayCheck {

    private $holidayVariable;
    private $year = \NULL;
    private $memorialDay;
    private $thanksgiving;
    private $dateFormat;
    private $urldate;

    public function checkForHoliday($urldate) {
        $this->dateFormat = new DateTime($urldate);
        $this->urldate = $this->dateFormat->format('Y-m-d');
        $this->year = \substr($this->urldate, 0, 4);
        $this->holidayVariable = \date("Y-m-d", \easter_date($this->year));

        if ($this->holidayVariable === $this->urldate) {
            return "Easter Sunday";
        }

        $this->memorialDay = \date("Y-m-d", \strtotime("Last Monday of May " . $this->year));
        if ($this->urldate == $this->memorialDay) {
            return "Memorial Day";
        }

        if ($this->urldate === $this->year . '-07-04') {
            return "Fourth of July";
        }

        $this->holidayVariable = \date("Y-m-d", \strtotime("First Monday of September " . $this->year));
        if ($this->urldate === $this->holidayVariable) {
            return "Labor Day";
        }

        if ($this->urldate === $this->year . "-10-31") {
            return "Halloween";
        }

        $this->thanksgiving = \date("Y-m-d", \strtotime("Fourth Thursday of November" . $this->year));
        if ($this->urldate === $this->thanksgiving) {
            return "Thanksgiving";
        }

        if ($this->urldate === $this->year . '-12-25') {
            return "Christmas Day";
        }

        if ($this->urldate === $this->year . '-01-01') {
            return "New Year's Day";
        }
    }

}
