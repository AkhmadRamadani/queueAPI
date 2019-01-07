<?php
// *
// *    Hello Model
// *    Author: Alfan Hidayatullah
// *

class helloModel extends Queue {


    // *
    // *    Get last inserted id
    // *
    public function lastInsertId() {

        return $this->db->lastInsertId();

    }

    
    // *
    // *    Insert Method
    // *
    public function insert ( $params ) {

        // Preparing query
        $insert = $this->db->prepare ("
            INSERT INTO `hello` (`id`, `name`) VALUES (NULL, :name);
        ");

        // Query execution
        return $insert->execute ( $params );

    }

    
    // *
    // *    Get Method
    // *
    public function get ( $params ) {

        // Preparing query
        $select = $this->db->prepare ("
            SELECT * FROM `hello`
        ");

        // Query execution
        $select->execute ( $params );

        // Get fetched data
        return $select->fetchAll(PDO::FETCH_ASSOC);

    }

}

?>