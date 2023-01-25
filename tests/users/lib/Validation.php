<?php

    class Validation {

        public function checkBRFullName($fullname) {

            $fullname = $this->removeExtraSpaces($fullname);
            
            // Looking for Brazilian Portuguese names
            if (strlen($fullname) <= 2 || strlen($fullname) > 40 || !preg_match("/^[a-zA-Z-ÇçÑñÁÉÍÓÚáéíóúÃÕãõÂÊÔâêôÈèöÖ \']*$/", $fullname)) {
            
                return 0;
            
            } else {

                return $fullname;

            }

        }

        public function checkBRCelPhone($phone) {

            // Accepted formats are (00) x0000-0000 and (00) 0000-0000            
            if (strlen($phone) <= 8 || strlen($phone) > 20 || !preg_match("/^\([0-9]{2}\) [0-9]?[0-9]{4}-[0-9]{4}$/", $phone)) {
            
                return 0;
            
            } else {

                return $phone;

            }

        }

        public function checkInstaUserFormat($instagram) {

            // To begin with the Instagram username has to be a string, then it has to match Instagram standards (2022)
            if (!preg_match("/^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$/", $instagram)) {
            
                return 0;
            
            } else {

                return $instagram;

            }

        }        

        public function removeExtraSpaces($data) {

            $result = trim($data);
            $result = preg_replace('/\s{2,}/', ' ', $result);

            return $result;

        }

        public function checkName($name) {

            $name = $this->testInput($name);
            
            if (preg_match("/^[a-zA-Z ]*$/", $name)) {
            
                return $name;
            
            } else {

                return 0;

            }

        }

        public function testInput($data) {

            $result = trim($data);
            $result = htmlspecialchars($result);
            $result = stripslashes($result);
            
            return $result;

        }

        public function checkNum($num) {
            
            if(is_numeric($num)) {

                return $num;

            } else {

                return 0;

            }

        }

        public function checkEmail($email) {
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                return 0;
                
            } else {
                
                // and then the domain is checked as well
                if (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {
    
                    return 0;
    
                }
            
            }

            return $email;
            
        }

        public function checkAndHashPasswordS($pwd, $cpwd) {

            // Password must have letters and numbers and be 8 characters long and less than 41 characters long
            if ( !isset($pwd) || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,40})/', $pwd) ) {

                return 0;
    
            } else {
    
                if ($pwd !== $cpwd) {
    
                    return 0;
    
                }
    
            }

            $pwd = password_hash($pwd, PASSWORD_DEFAULT);

            return $pwd;

        }

        public function checkPassword($pwd) {

            // Password must have letters and numbers and be 8 characters long and less than 41 characters long
            if ( !isset($pwd) || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,40})/', $pwd) ) {

                return 0;
    
            }

            $pwd = password_hash($pwd, PASSWORD_DEFAULT);

            return $pwd;

        }

    }

?>