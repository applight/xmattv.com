<?php

class MyDB extends SQLite3 {
    
    public function __construct() {
        $this->open('users.db');
    }

    public function attempt($q, $succ="Success!") {
        return $this->exec($q) ? $succ : $this->lastErrorMsg();
    }

    /**
     * returns []   if no key-value match exits in TABLE $table
     *              otherwise, returns the row as an assoc array
     */
    public function exists($key, $value, $table) {
        $q =<<<EOF
        SELECT * from {$table} WHERE {$key}={$value};
        EOF;
        return $this->querySingle($q, true);
    }

    public function select($key, $value, $table) {
        return $this->query(<<<EOF
        SELECT * from {$table} WHERE {$key}={$value};
        EOF);
    }

    public function firstSelect($key, $value, $table) {
        return $this->querySingle(<<<EOF
        SELECT * from {$table} WHERE {$key}={$value}; 
        EOF, true);
    }

}



class UserManagement {

    static function createDatabase() {
        
        // opens or creates sqllite database
        $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
        } else {
            echo "Opened database successfully\n";
        }

        echo $db->attempt(
            <<<EOF
            CREATE TABLE USERS
            (ID INT PRIMARY KEY     NOT NULL,
            FIRST_NAME      TEXT    NOT NULL,
            LAST_NAME       TEXT    NOT NULL,
            EMAIL           TEXT    NOT NULL,
            EMAIL_VERIFIED  INT     NOT NULL,
            PHONE           INT     NOT NULL,
            PHONE_VERIFIED  INT     NOT NULL)
            EOF,
            "User table successfully created!\n"    
        );

        echo $db->attempt(
            <<<EOF
            CREATE TABLE NOTIFICATIONS
            (PHONE INT PRIMARY KEY     NOT NULL,
            NOTIFICATIONS      INT     NOT NULL);
            EOF,
            "Notifications table successfully created!\n"
        );

        $db->close();

    }

    static public function doNotifications( $phone, $f ) {
        $db = new MyDB();

        $row  = $db->exists("PHONE", $phone, "NOTIFICATIONS");
        
        $q = null;
        if ($row == []) {
            $q =<<<EOF
            INSERT INTO NOTIFICATIONS (PHONE,NOTIFICATIONS)
            VALUES ($phone, 1);
            EOF;
        } else {
            $notes = $f($row['NOTIFICATIONS']);
            $q =<<<EOF
            UPDATE NOTIFICATIONS set NOTIFICATIONS = {$notes} 
            WHERE PHONE={$phone};
            EOF;
        }

        $ret = $db->query($q);
        $db->close();
        return $ret;
    }

    static public function incNotifications( $phone ) {
        return doNotifications( $phone, function ($noteCount) { return $noteCount++; } );
    }

    static public function seeNotifications( $phone ) {
        return doNotifications( $phone, function ($noteCount) { return 0; } );
    }

    static public function getNotifications( $phone ) {
        $row = $db->exists("PHONE", $phone, "NOTIFICATIONS");
        if ($row != []) {
            return $row['NOTIFICATIONS'];
        } else {
            return 0;
        }
    }

    static public function registerUser( $first, $last, $email, $phone ) {

    }

    static public function verifyEmail( $id ) {

    }
    
    static function verifyPhone( $id ) {

    }

}

?>