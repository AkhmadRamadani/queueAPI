<?php

    class placeModel extends Queue
    {
        public function getRegisterPlace ($params) {

            $insert = $this->db->prepare ("
                INSERT INTO `place` (`id_place`, `name_place`, `address`, `picture`, `id_user`,`status`,`inisial`) 
                VALUES (NULL, :name_place, :address, :picture, :id_user , 'open', :name_place)
            ");
    
            return $insert->execute ($params);
    
        }

        public function getQueue ($params) {

            $insert = $this->db->prepare ("
                INSERT INTO `queue` (`id_place`, `id_user`, `queue_code`, `status`, `id_queue`) 
                VALUES (:id_place, :id_user, :queue_code, 'waiting', NULL)
            ");
    
            return $insert->execute ($params);
    
        }
        public function updatePlaceStatus($params)
        {
            $update = $this->db->prepare("
                UPDATE `place` SET `status` = :status WHERE :id_place = `id_place`
            ");
            return $update->execute ($params);
        }
        public function cancelingQueue($params)
        {
            $delete = $this->db->prepare("
                DELETE FROM `queue` WHERE :queue_code = `queue_code`
            ");
            return $delete->execute ($params);
        }
        public function getOpenPlace()
        {
            $select = $this->db->prepare("
                SELECT * from `place` WHERE `status` = 'open' 
            ");
            $select->execute();
    
            return $select->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getMyQueue($params)
        {
            $select = $this->db->prepare("
                SELECT * FROM place p, queue q, user u WHERE p.id_place = q.id_place 
                AND u.id_user = q.id_user 
                AND u.id_user = :id_user AND q.status = 'waiting'
            ");
            $select->execute($params);
            
            return $select->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getMyPlaceQueue($params)
        {
            $select = $this->db->prepare("
                SELECT * FROM place p, queue q, user u WHERE p.id_place = q.id_place AND u.id_user = q.id_user 
                AND p.id_place = :id_place AND q.status = 'waiting'
            ");
            $select->execute($params);
    
            return $select->fetchAll(PDO::FETCH_ASSOC);
        }
        public function updateQueueStatus($params)
        {
            $update = $this->db->prepare("
                UPDATE `queue` SET `status` = :status WHERE :id_queue = `id_queue`
            ");
            return $update->execute ($params);
        }
        public function searchPlace($params)
        {
            $sql = " SELECT * FROM place WHERE name LIKE '%:name%' ";
           foreach( $params AS $key => $value ) {
                $sql = str_replace( $key, $value, $sql );
            }
            $select = $this->db->prepare($sql);
        
            $select->execute($params);
    
            return $select->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getMyPlace($params)
        {
            $select = $this->db->prepare("
                SELECT * from `place` WHERE `id_user` = :id_user 
            ");
            $select->execute($params);
    
            return $select->fetch(PDO::FETCH_ASSOC);
        }
        public function lastInsertId($params) {

            $select = $this->db->prepare("
                SELECT count(*) FROM `queue` WHERE `id_place` = :id_place 
            ");
            $select->execute($params);
            return $select->fetchColumn();  
        }
        public function getInisial($params) {

            $select = $this->db->prepare("
                SELECT inisial FROM `place` WHERE `id_place` = :id_place 
            ");
            $select->execute($params);
            return $select->fetchColumn();  
        }
        public function backUpData($params)
        {
            $backup = $this->db->prepare("
                INSERT INTO backup_queue (`id_place`, `id_user`, `queue_code`, `status`) 
                SELECT `id_place` , `id_user`, `queue_code` , `status` FROM queue WHERE `id_place` = :id_place                
            ");
            return $backup->execute ($params);
        }
        public function resetData($params)
        {
            $delete = $this->db->prepare("
                DELETE FROM `queue` WHERE `id_place` = :id_place
            ");
            return $delete->execute($params);
        }
        
        public function getSisaAntrean($params) {

            $select = $this->db->prepare("
                SELECT count(*) FROM `queue` WHERE `id_place` = :id_place and `status` = 'waiting'
            ");
            $select->execute($params);
            return $select->fetchColumn();  
        }
        public function getOnProcessKode($params)
        {
            $select = $this->db->prepare("
                SELECT queue_code from `queue` WHERE `status` = 'on' and id_place = :id_place
            ");
            $select->execute($params);
    
            return $select->fetchColumn();
        }
    }


?>