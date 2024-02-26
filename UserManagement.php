<?php

require_once './vendor/autoload.php';

use Twilio\Rest\Client;

//$twilio = new Client(getenv("TWILIO_ACCOUNT_SID"), getenv("TWILIO_AUTH_TOKEN"));

class MyDB extends SQLite3 {
    
    public function __construct() {
        $this->open('./users.db');
    }

    public function attempt($q, $succ="Success!") {
        return $this->exec($q) ? $succ : $this->lastErrorMsg();
    }

    public function exists($key, $value, $table) {
        $value = "'" . $value . "'";
        return $this->querySingle(<<<EOF
            SELECT * from {$table} WHERE {$key}={$value};
            EOF, 
            true);
    }

    public function select($key, $value, $table) {
        $value = "'" . $value . "'";
        return $this->query(<<<EOF
        SELECT * from {$table} WHERE {$key}={$value};
        EOF);
    }

    public function firstSelect($key, $value, $table) {
        $value = "'" . $value . "'";
        return $this->querySingle(<<<EOF
        SELECT * from {$table} WHERE {$key}={$value}; 
        EOF, true);
    }

}

class UserManagement {

    static private $DEBUG = true;

    static public function createDatabase() {
        
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
            VALUES ('{$phone}', '1');
            EOF;
        } else {
            $notes = $f($row['NOTIFICATIONS']);
            $q =<<<EOF
            UPDATE NOTIFICATIONS set NOTIFICATIONS = {$notes} 
            WHERE PHONE='{$phone}';
            EOF;
        }

        $ret = $db->query($q);
        $db->close();
        return $ret;
    }

    static public function incNotifications( $phone ) {
        return doNotifications( $phone, function ($noteCount) { return ++$noteCount; } );
    }

    static public function seeNotifications( $phone ) {
        return doNotifications( $phone, function ($noteCount) { return 0; } );
    }

    /**
     * check arguments for validity, this is injection suceptable 
     */
    static public function registerUser( $first, $last, $email, $phone ) {
        $db = new MyDB();

        if ( $db->exists("PHONE", $phone, "USERS") == [] ) {
    
            if ( self::$DEBUG ) {
                echo "<p>No user yet</p>";  
            }

            $authy_api = new Authy\AuthyApi(getenv("AUTHY_API_KEY"));
            $user = $authy_api->registerUser($email, substr($phone, 2), 1); // email, cellphone, country_code

            if ( self::$DEBUG ) {
                if($user->ok()) {
                    echo "<p>" . $user->id() . "</p>";
                } else {
                    foreach($user->errors() as $field => $message) {
                        echo "<p>" . $field  . " = " . $message . "</p>";
                    }
                }
            }
            
            $authyid = $user->id();

            $result = $db->attempt(
                <<<EOF
                INSERT INTO USERS (FIRST_NAME,LAST_NAME,EMAIL,EMAIL_VERIFIED,PHONE,PHONE_VERIFIED,AUTHY_ID) 
                VALUES ('{$first}','{$last}','{$email}','0','{$phone}','0','{$authyid}');
                EOF,
                "Added user successfully"
            );

            if ( self::$DEBUG ) {
                echo "<p>{$result}</p>";
            }

            $row = $db->exists("PHONE", $phone, "USERS");
            if ( $row != [] ) {
                return $row["PHONE"];
            } else {
                if ( self::$DEBUG ) {
                    echo "<p>User did not get added to database</p>";
                }
                // this means we couldn't write to the database...
                return false;
            }
        }
        if ( self::$DEBUG ) {
            echo "<p>User exists came back with a user</p>";
        }
        // user existed
        return false;
    }

    /**
     * returns  false if the user is not registered
     *          otherwise: the result of the query
     */
    static public function verifyEmail( $id ) {
        $db = new MyDB();

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
        $db = new MyDB();

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

    static function verifyOtp( $phone, $userOtp ) {
        $db = new MyDB();
        $authy_api = new Authy\AuthyApi(getenv("AUTHY_API_KEY"));

        $row = $db->exists("PHONE", $phone, "USERS");
        if ( $row != [] ) {
            $authy_id = $row['AUTHY_ID'];
            $verification = $authy_api->verifyToken($authy_id, $userOtp);
            if ($verification->ok()) return $verification;
            else return false;
        }
        return false;
    }

    static function newOtp( $phone ) {
        $db = new MyDB();
        $authy_api = new Authy\AuthyApi(getenv("AUTHY_API_KEY"));

        $row = $db->exists("PHONE", $phone, "USERS");
        if ( $row != [] ) {
            $authy_id = $row['AUTHY_ID'];
            $sms = $authy_api->requestSms($authy_id);
            if ($sms->ok()) return $sms;
            else return false;
        }
        return false;   
    }

}
