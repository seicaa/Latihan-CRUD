<?php

    $connect = new PDO("mysql:host=localhost;dbname=latihan", "root", "");
    $received_data = json_decode(file_get_contents("php://input"));

    $data = array();

    if($received_data->action == 'fetchall')
    {

        $query      = "SELECT * FROM tbl_sample ORDER BY id DESC";
        $statement  = $connect->prepare($query);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        
        echo json_encode($data);
    }

    	

    if($received_data->action == 'insert')
    {
        $data = array(
            ':first_name' => $received_data->first_name,
            ':last_name' => $received_data->last_name
        );
            
        $query = "INSERT INTO tbl_sample (first_name, last_name) VALUES (:first_name, :last_name)";
        $statement  = $connect->prepare($query);
        $statement->execute($data);

    }

        
    

    if($received_data->action == 'update')
    {
        $data = array(
            ':first_name'   => $received_data->first_name,
            ':last_name'    => $received_data->last_name,
            ':id'           => $received_data->id
        );
            
        $query = "UPDATE tbl_sample SET first_name = :first_name, last_name = :last_name WHERE id = :id";
            
        $statement = $connect->prepare($query);
            
        $statement->execute($data);
    }


    if($received_data->action == 'delete')
    {
        $data = array(
            ':id'           => $received_data->id
        );
            
        $query = "DELETE FROM tbl_sample WHERE id = :id";
        
        $statement = $connect->prepare($query);
            
        $statement->execute($data);
    }


    
    
?>