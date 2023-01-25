<?php

    require_once 'init.php';

    class User {

        public $db;
        public $validation;

        public function __construct() {

            $this->db = new Database();
            $this->validation = new Validation();

        }

        public function getUser($id) {

            $query = "SELECT * FROM users WHERE id = :id";
            
            $this->db->query($query);
            $this->db->bind('id', $id);
            
            return $this->db->singleResult();
        
        }

        public function searchUser() {

            $keyword = $_POST['keyword'];
            
            $query = "SELECT * FROM users WHERE fullname LIKE :keyword OR email LIKE :keyword OR instagram LIKE :keyword OR phone LIKE :keyword ";
            
            $this->db->query($query);
            $this->db->bind('keyword', "%$keyword%");
            
            return $this->db->resultAll();

        }

        public function insertUser() {

            $fullname  = $this->validation->checkBRFullName($_POST['fullname']);
            $phone     = $this->validation->checkBRCelPhone($_POST['phone']);
            $instagram = $this->validation->checkInstaUserFormat($_POST['instagram']);            
            $email     = $this->validation->checkEmail($_POST['email']);
            $pwd       = $this->validation->checkAndHashPasswordS($_POST['pwd'], $_POST['cpwd']);

            if(($fullname && $phone && $instagram && $email && $pwd) == 0) {
                
                return 0;
                exit;

            } else {
                
                $query = "INSERT INTO users (fullname, phone, instagram, email, pwd, verified, created_at) VALUES (:fullname, :phone, :instagram, :email, :pwd, 'N', NOW())";

                $this->db->query($query);

                $this->db->bind('fullname', $fullname);
                $this->db->bind('phone', $phone);
                $this->db->bind('instagram', $instagram);
                $this->db->bind('email', $email);
                $this->db->bind('pwd', $pwd);

                $this->db->execute();
                
                return $this->db->rowCount();

            }

        }

        public function updateUser() {

            $fullname  = $this->validation->checkBRFullName($_POST['fullname']);
            $phone     = $this->validation->checkBRCelPhone($_POST['phone']);
            $instagram = $this->validation->checkInstaUserFormat($_POST['instagram']);            
            $email     = $this->validation->checkEmail($_POST['email']);
            $pwd       = $this->validation->checkPassword($_POST['pwd']);

            $id = $_POST['id'];

            if(($fullname && $phone && $instagram && $email && $pwd) == 0) {

                return 0;
                exit;

            } else {

                $query = "UPDATE users SET fullname = :fullname, phone = :phone, instagram = :instagram, email = :email, pwd = :pwd WHERE id = :id";
                
                $this->db->query($query);

                $this->db->bind('fullname', $fullname);
                $this->db->bind('phone', $phone);
                $this->db->bind('instagram', $instagram);
                $this->db->bind('email', $email);
                $this->db->bind('pwd', $pwd);
                $this->db->bind('id', $id);

                $this->db->execute();
                
                return $this->db->rowCount();
            
            }
        
        }

        public function deleteUser($id) {

            $query = "DELETE FROM users WHERE id = :id";
            
            $this->db->query($query);
            $this->db->bind('id', $id);
            $this->db->execute();
            
            return $this->db->rowCount();
        
        }        

    }

?>