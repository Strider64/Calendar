<?php

namespace website_project\calendar;

use DateTime;
use DateTimeZone;

class Holidays {

    public $holidays = [
        'new year\'s day' => NULL,
        'easter sunday' => NULL,
        'memorial day' => NULL,
        'fourth of july' => NULL,
        'labor day' => NULL,
        'halloween' => NULL,
        'thanksgiving day' => NULL,
        'christmas day' => NULL
    ];
    protected $year = NULL;

    public function __construct($year = 2015) {
        $this->holidays = $this->generate_holidays($year);
    }

    protected function generate_holidays($year) {

        $this->year = new DateTime('1-1-' . $year, new DateTimeZone('America/Detroit')); // Set the year that is to generate the holidays:

        /* New Year's Day */
        $this->holidays['new year\'s day'] = $this->year->format('l, F j, Y');
        /* Easter Sunday */
        $this->holidays['easter sunday'] = $this->year->modify('@' . easter_date($this->year->format("Y")))->format('l, F j, Y');
        /* Memorial Day */
        $this->holidays['memorial day'] = $this->year->modify('Last monday of may')->format('l, F j, Y');
        /* Fourth of July */
        $this->holidays['fourth of july'] = $this->year->modify('July 4, ' . $year)->format('l, F j, Y');
        /* Labor Day */
        $this->holidays['labor day'] = $this->year->modify('First monday of september')->format('l, F j, Y');
        /* Halloween */
        $this->holidays['halloween'] = $this->year->modify('October 31, ' . $year)->format('l, F j, Y');
        /* Thanksgiving Day */
        $this->holidays['thanksgiving day'] = $this->year->modify('Fourth thursday of November')->format('l, F j, Y');
        /* Christmas Day */
        $this->holidays['christmas day'] = $this->year->modify('December 25, ' . $year)->format('l, F j, Y');
        /* Return Array to Constructor */
        return $this->holidays;
    }

}
