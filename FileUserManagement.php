<?php

class User {

    static private function write( $file, $array ) {
        return file_put_contents( $file, json_encode($array) );
    }
    static private function read( $file ) {
        return json_decode( file_get_contents($file), true );
    }
    
    static private $DBPATH = './filedb/users/';

    static public function create($first, $last, $email, $phone) {
        if ( ! file_exists(self::$DBPATH . $phone) ) {
            self::write( self::$DBPATH . "\\" . $phone, 
                Array( "first_name" => $first, "last_name" => $last, 
                "email" => $email, "phone" => $phone, 
                "phone_verified" => false, "email_verified" => false, 
                "otp" => NULL ) 
            );
        } else {
            return false;
        }     
    }

    static public function select($phone) {
        if ( file_exists(self::$DBPATH . $phone) ) {
            $keyValues = self::read( self::$DBPATH . "\\" . $phone );
            return new User( $keyValues );
            //return new User($keyValues['first_name'], $keyValues['last_name'], $keyValues['email'], $keyValues['phone'], $keyValues['email_verified'], $keyValues['phone_verified'], $keyValues['otp']);
        }
    }

    private $keyValues = [];
    private function __construct($keyValues) {
        $this->keyValues = $keyValues;
    }

    public function getFirst() {
        return $this->keyValues['first_name'];
    }

    public function getLast() {
        return $this->keyValues['last_name'];
    }

    public function getEmail() {
        return $this->keyValues['email'];
    }

    public function getPhone() {
        return $this->keyValues['phone'];
    }

    public function verifyPhone($otp) {
        return $twilio->verify->v2->services("VA682a63884e464fbbcaab78d1f71af91a")
            ->verificationChecks
            ->create([
                        "to" => $keyValues['phone'],
                        "code" => $otp
            ]);
    }

    public function sendVerficationCode() {
        return $twilio->verify->v2->services("VA682a63884e464fbbcaab78d1f71af91a")
            ->verifications
            ->create($keyValues['phone'], "sms");
    }


}

?>