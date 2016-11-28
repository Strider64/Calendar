<?php

namespace website_project\calendar;

//use website_project\database\MyPDO;
use website_project\database\Database as DB;
use DateTime;
use DateTimeZone;
use PDO;

abstract class Location {

    protected $php_self = \NULL;
    protected $path_parts = \NULL;
    protected $basename = \NULL;
    protected $location;
    public $pdo = \NULL;

    public abstract function fileLocation();


    public function changeDate() {
        $this->location = filter_input(INPUT_GET, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (isset($this->location) && ($this->location === 'prev' || $this->location === 'next')) {
            if ($this->location === 'prev') {
                $_SESSION['displayDate']->modify("-1 month");
            } elseif ($this->location === 'next') {
                $_SESSION['displayDate']->modify("+1 month");
            }
        } else {
            unset($_SESSION['displayDate']);
            $_SESSION['displayDate'] = new DateTime("Now", new DateTimeZone("America/Detroit"));
        }
        return $_SESSION['displayDate']->format("F Y");
    }

    public function myPDO() {
        $db = DB::getInstance();
        return $this->pdo = $db->getConnection();
    }

    protected function returnLocation() {
        $this->php_self = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);
        $this->path_parts = pathinfo($this->php_self);
        $this->basename = $this->path_parts['basename'];
        return $this->basename;
    }

}
