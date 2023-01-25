<?php

   require_once 'init.php';

   class Pagination {

      public $recordsPerPage = 5;
      public $startData;
      public $activePage;
      public $totalPages;
      public $totalRecords;
      public $query = "SELECT * FROM users ORDER BY fullname ASC ";
      public $page_url = 'index.php';
      public $db;

      public function __construct(){

         $this->db = new Database();

      }

      public function totalRecords(){

         $this->db->query("SELECT * FROM users");

         $data = $this->db->resultAll();

         return count($data);

      }

      public function totalPages(){

         return ceil($this->totalRecords() / $this->recordsPerPage);

      }

      public function showDataPaging(){

         // $this->db = new Database();
         $this->activePage = isset($_GET['page']) ? $_GET['page'] : 1;

         $this->startData = ($this->recordsPerPage * $this->activePage) - $this->recordsPerPage;

         $this->query .= "LIMIT $this->startData, $this->recordsPerPage";

         $this->db->query($this->query);

         return $this->db->resultAll();

      }

      public function pagingButton(){

         if ($this->activePage > 1) {

            echo '<li class="page-item"><a class="page-link" href="'.$this->page_url.'">First Page</a></li>';

         } else {

            echo '<li class="page-item disabled"><a class="page-link" href="'.$this->page_url.'">First Page</a></li>';

         }

         for ($i = 1; $i <= $this->totalPages(); $i++) {
            
            if ($i == $this->activePage) {
               
               echo '<li class="page-item active"><a class="page-link" href="'.$this->page_url.'?page='.$i.'">'.$i.'</a></li>';
            
            } else {
               
               echo '<li class="page-item"><a class="page-link" href="'.$this->page_url.'?page='.$i.'">'.$i.'</a></li>';
            
            }
         
         }

         if($this->activePage < $this->totalPages()) {
            
            echo '<li class="page-item"><a class="page-link" href="'.$this->page_url.'?page='.$this->totalPages().'">Last Page</a></li>';
         
         } else {
            
            echo '<li class="page-item disabled"><a class="page-link" href="'.$this->page_url.'?page='.$this->totalPages().'">Last Page</a></li>';
         
         }
      
      }
   
   }

?>