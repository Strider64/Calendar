<?php

namespace website_project\users;

use PDO;
use DateTime;
use website_project\database\Database as DB;

class Tracker {

    protected $query = \NULL;
    protected $stmt = \NULL;
    protected $password = \NULL;
    protected $user = \NULL;
    protected $created = \NULL;
    public $userArray = [];
    public $result = \NULL;
    public $valid = \NULL;

    public function __construct() {
        
    }

    public function create(array $data = []) {
        
        $this->created = new DateTime("Now", new \DateTimeZone("America/Detroit"));
        $this->password = password_hash($data['password'], PASSWORD_BCRYPT, array("cost" => 15));
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'INSERT INTO tracker '
                . '(name, password, email, location, startLat, startLon, destination, endLat, endLon, totalDistance, dateCreated, goal) '
                . 'VALUES '
                . '(:name, :password, :email, :location, :startLat, :startLon, :destination, :endLat, :endLon, :totalDistance, :dateCreated, :goal)';

        /* Prepare the query */
        $this->stmt = $pdo->prepare($this->query);
        /* Execute the query with the stored prepared values */
        $this->result = $this->stmt->execute([
            ':name' => $data['name'],
            ':password' => $this->password,
            ':email' => $data['email'],
            ':location' => $data['location'],
            ':startLat' => $data['startLat'],
            ':startLon' => $data['startLon'],
            ':destination' => $data['destination'],
            ':endLat' => $data['endLat'],
            ':endLon' => $data['endLon'],
            ':totalDistance' => $data['totalDistance'],
            ':dateCreated' => $this->created->format("Y-m-d H:i:s"),
            ':goal' => $data['totalDistance']
        ]);
        return $this->result;
    }

    public function read($name, $password) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT * FROM tracker WHERE name=:name';

        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':name' => $name]); // Execute the query with the supplied user's parameter(s):

        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        $this->user = $this->stmt->fetch();

        /*
         * If password matches database table match send back true otherwise send back false.
         */
        if (password_verify($password, $this->user->password)) {

            $this->userArray['id'] = $this->user->id;
            $this->userArray['name'] = $this->user->name;
            $this->userArray['security'] = $this->user->security;
            $this->userArray['email'] = $this->user->email;
            $this->userArray['csrf_token'] = $_SESSION['csrf_token'];

            return (object) $this->userArray;
        } else {
            return NULL;
        }
    }

    public function delete() {
        unset($_SESSION['trackerMember']);
        $_SESSION['trackerMember'] = NULL;
        session_destroy();
        return TRUE;
    }

    public function phpDate($myDate, $format = 'Y-m-j') {
        $d = DateTime::createFromFormat($format, $myDate);
        return $d && $d->format($format) == $myDate;
    }

}
