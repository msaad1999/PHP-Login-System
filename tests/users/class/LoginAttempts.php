<?php

    require_once 'init.php';

    class LoginAttempt {

        public $db;
        //public $validation;

        public function __construct() {

            $this->db = new Database();
            $this->validation = new Validation();

        }

        public function getLoginAttempt($id) {

            $query = "SELECT * FROM login_attempts WHERE id = :id ";
            
            $this->db->query($query);
            $this->db->bind('id', $id);
            
            return $this->db->singleResult();
        
        }

        public function searchLoginAttempt() {

            $keyword = $_POST['keyword'];
            
            $query = "SELECT * FROM login_attempts WHERE ip LIKE :keyword OR timestamp LIKE :keyword OR user_id LIKE :keyword ";
            
            $this->db->query($query);
            $this->db->bind('keyword', "%$keyword%");
            
            return $this->db->resultAll();

        }

        public function insertLoginAttempt() {

            $user_id   = $this->$_POST['used_id'];
            $ip        = $this->$_POST['ip'];

            if(($user_id && $ip) == 0) {
                
                return 0;
                exit;

            } else {
                
                $query = "INSERT INTO login_attempts (user_id, ip, timestamp) VALUES (:user_id, :ip, NOW())";

                $this->db->query($query);

                $this->db->bind('user_id', $user_id);
                $this->db->bind('ip', $ip);

                $this->db->execute();
                
                return $this->db->rowCount();

            }

        }

        public function updateLoginAttempt() {

            $user_id   = $this->$_POST['used_id'];
            $ip        = $this->$_POST['ip'];

            $id = $_POST['id'];

            if(($user_id && $ip) == 0) {

                return 0;
                exit;

            } else {

                $query = "UPDATE login_attempts SET user_id = :user_id, ip = :ip, timestamp = NOW() ";
                
                $this->db->query($query);

                $this->db->bind('user_id', $user_id);
                $this->db->bind('ip', $ip);

                $this->db->bind('id', $id);

                $this->db->execute();
                
                return $this->db->rowCount();
            
            }
        
        }

        public function deleteLoginAttempt($id) {

            $query = "DELETE FROM login_attempts WHERE id = :id";
            
            $this->db->query($query);
            $this->db->bind('id', $id);
            $this->db->execute();
            
            return $this->db->rowCount();
        
        }        

    }

?>