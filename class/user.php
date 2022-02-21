<?php
    class Users{
        // connection
        private $connection;

        private $db_table = "users";
        // Columns
        public $user_id;
        public $user_name;
        public $user_phone;
        public $user_status;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }
        // GET ALL
        public function getUsers(){
            $sqlQuery = "SELECT user_id, user_name, user_phone, user_status FROM " . $this->db_table . " ORDER BY user_id DESC";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createUsers(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        user_name = :user_name, 
                        user_phone = :user_phone, 
                        user_status = :user_status";
        
            $stmt = $this->connection->prepare($sqlQuery);
        
            // sanitize
            $this->user_name=htmlspecialchars(strip_tags($this->user_name));
            $this->user_phone=htmlspecialchars(strip_tags($this->user_phone));
            $this->user_status=htmlspecialchars(strip_tags($this->user_status));
        
            // bind data
            $stmt->bindParam(":user_name", $this->user_name);
            $stmt->bindParam(":user_phone", $this->user_phone);
            $stmt->bindParam(":user_status", $this->user_status);

        
            if($stmt->execute()){
               return true;
            }
            print_r($stmt->errorInfo());
            return false;
        }

        // READ single
        public function getSingleUser(){
            $sqlQuery = "SELECT
                        user_id, 
                        user_name, 
                        user_phone, 
                        user_status
                      FROM
                        ". $this->db_table ."
                    WHERE 
                    user_id = ?
                    LIMIT 1";

            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->bindParam(1, $this->user_id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->user_name = $dataRow['user_name'] ?? null;
            $this->user_phone = $dataRow['user_phone'] ?? null;
            $this->user_status = $dataRow['user_status'] ?? null;
        }      

        // UPDATE
        public function updateUsers(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        user_name = :user_name, 
                        user_phone = :user_phone, 
                        user_status = :user_status
                    WHERE 
                        user_id = :user_id";
                        
            $stmt = $this->connection->prepare($sqlQuery);
        
            $this->user_name=htmlspecialchars(strip_tags($this->user_name));
            $this->user_phone=htmlspecialchars(strip_tags($this->user_phone));
            $this->user_status=htmlspecialchars(strip_tags($this->user_status));
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            
            // bind data
            $stmt->bindParam(":user_name", $this->user_name);
            $stmt->bindParam(":user_phone", $this->user_phone);
            $stmt->bindParam(":user_status", $this->user_status);
            $stmt->bindParam(":user_id", $this->user_id);

            if($stmt->execute()){
                return true;
            }
            print_r($stmt->errorInfo());
            return false;
        }

        // DELETE
        function deleteUser(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE user_id = ?";
            $stmt = $this->connection->prepare($sqlQuery);
        
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        
            $stmt->bindParam(1, $this->user_id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>