<?php

class User
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "users";

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $create_date;
    public $update_date;


    public function __construct($db)
    {
        $this->db_conn = $db;
    }


    function create()
    {
        //write query
        $sql = "INSERT INTO " . $this->table_name . " SET first_name = ?, last_name = ?, email = ?, create_date = ?, update_date = ?";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->first_name);
        $prep_state->bindParam(2, $this->last_name);
        $prep_state->bindParam(3, $this->email);
        $prep_state->bindValue(4, $this->create_date);
        $prep_state->bindValue(5, $this->update_date);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }

    // for pagination
     public function countAll()
     {
         $sql = "SELECT id FROM " . $this->table_name;

         $prep_state = $this->db_conn->prepare($sql);
         $prep_state->execute();

         $num = $prep_state->rowCount(); //Returns the number of rows affected by the last SQL statement
         return $num;
     }


     function update()
     {
         $sql = "UPDATE " . $this->table_name . " SET first_name = :first_name, last_name = :last_name, email = :email, update_date = :update_date  WHERE id = :id";
         // prepare query
         $prep_state = $this->db_conn->prepare($sql);

         $timestamp = date('Y-m-d H:i:s');
         $this->update_date = $timestamp;

         $prep_state->bindParam(':first_name', $this->first_name);
         $prep_state->bindParam(':last_name', $this->last_name);
         $prep_state->bindParam(':email', $this->email);
         $prep_state->bindParam(':update_date', $this->update_date);
         $prep_state->bindParam(':id', $this->id);

         // execute the query
         if ($prep_state->execute()) {
             return true;
         } else {
             return false;
         }
     }


     function delete($id)
     {
         $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id ";

         $prep_state = $this->db_conn->prepare($sql);
         $prep_state->bindParam(':id', $this->id);

         if ($prep_state->execute(array(":id" => $_GET['id']))) {
             return true;
         } else {
             return false;
         }
     }


     function getAllUsers($from_record_num, $records_per_page)
     {
         $sql = "SELECT id, first_name, last_name, email, create_date, update_date FROM " . $this->table_name . " ORDER BY id ASC LIMIT ?, ?";


         $prep_state = $this->db_conn->prepare($sql);


         $prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
         $prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);


         $prep_state->execute();

         return $prep_state;
     }

    // for edit user form when filling up
     function getUser()
     {
         $sql = "SELECT first_name, last_name, email, create_date, update_date FROM " . $this->table_name . " WHERE id = :id";

         $prep_state = $this->db_conn->prepare($sql);
         $prep_state->bindParam(':id', $this->id);
         $prep_state->execute();

         $row = $prep_state->fetch(PDO::FETCH_ASSOC);

         $this->first_name = $row['first_name'];
         $this->last_name = $row['last_name'];
         $this->email = $row['email'];
     }


}







