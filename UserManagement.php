<?php

require_once './vendor/autoload.php';

use Twilio\Rest\Client;
$twilio = new Client(getenv("TWILIO_ACCOUNT_SID"), getenv("TWILIO_AUTH_TOKEN"));

class MyDB extends SQLite3 {
    
    public function __construct() {
        parent::__construct();
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

    static private function createDatabase() {
        
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
            PHONE_VERIFIED  INT     NOT NULL,
            TOKEN           TEXT    NULL)
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

    /**
     * check arguments for validity, this is injection suceptable 
     */
    static public function registerUser( $first, $last, $email, $phone ) {
        if ( $db->exists("EMAIL", $email, "USERS") == [] ) {
            $db->query(<<<EOF
            INSERT INTO USERS (FIRST_NAME,LAST_NAME,EMAIL,EMAIL_VERIFIED,PHONE,PHONE_VERIFIED) 
            VALUES ({$first},{$last},{$email},0,{$phone},0);
            EOF);
            return ($db->exists("EMAIL", $email, "USERS"))["ID"];
        }
        // user existed
        return false;
    }

    /**
     * returns  false if the user is not registered
     *          otherwise: the result of the query
     */
    static public function verifyEmail( $id ) {

        if ( $db->exists("ID", $id, "USERS") != [] ) {
            return $db->query(<<<EOF
            UPDATE USERS set EMAIL_VERIFIED = 1 
            WHERE ID={$id};
            EOF);
        }
        return false;
    }
    
    /**
     * returns  false if the user is not registered
     *          otherwise: the result of the query
     */
    static function verifyPhone( $id, $userOtp ) {
        $row = $db->exists("ID", $id, "USERS");
        if ( $row != [] ) {
            $verification_check = verifyOtp( $id, $userOtp );
            
            if ( $verification_check && $verification_check != false ) { 
                if ( $verification_check->status == "approved" ) { 
                    return $db->query(<<<EOF
                    UPDATE USERS set PHONE_VERIFIED = 1 
                    WHERE ID={$id};
                    EOF);
                } else {
                    return $db->query(<<<EOF
                    UPDATE USERS set PHONE_VERIFIED = 0 
                    WHERE ID={$id};
                    EOF);
                }
            }
        }
        return false;
    }

    static function verifyOtp( $id, $userOtp ) {
        $row = $db->exists("ID", $id, "USERS");
        if ( $row != [] ) {
            return $twilio->verify->v2->services("VA682a63884e464fbbcaab78d1f71af91a")
            ->verificationChecks
            ->create([
                        "to" => $row['PHONE'],
                        "code" => $userOtp
            ]);
        }
        return false;
    }

    static function newOtp( $id ) {
        $row = $db->exists("ID", $id, "USERS");
        if ( $row != [] ) {

            $verification = $twilio->verify->v2->services("VA682a63884e464fbbcaab78d1f71af91a")
            ->verifications
            ->create($row['PHONE'], "sms");

            return $verification;
        }
        return false;
    }

}

?>