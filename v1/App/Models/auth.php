<?php 
    class authModel extends Queue{

        public function getLoginData ($params) {

            $select = $this->db->prepare ("
                SELECT * FROM `user` WHERE :email = email && :password = password
            ");
    
            $select->execute ($params);
    
            return $select->fetch(PDO::FETCH_ASSOC);
    
        }

        public function getRegisterData ($params) {

            $insert = $this->db->prepare ("
                INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `photoprofile`, `level`)
                 VALUES (NULL, :name, :email, :password, 'profile/man.png' , 'user')
            ");
    
            return $insert->execute ($params);
    
        }
        
        public function checkEmail($params)
        {  
            $check = $this->db->prepare("
                SELECT `email` FROM `user` where :email = email
            ");
            $check->execute ($params);
            
            return $check->fetchAll(PDO::FETCH_ASSOC);
        }

        public function beforeForgetPass($params)
        {  
            $check = $this->db->prepare("
                SELECT * FROM `user` where :email = email
            ");
            $check->execute ($params);
            
            return $check->fetch(PDO::FETCH_ASSOC);
        }

        public function updateProfil($params)
        {
            $update = $this->db->prepare("
                UPDATE `user` SET `name` = :name, `email` = :email, `password` = :password, `photoprofile` = :photoprofile
                 WHERE :id_user = `id_user`
            ");
            return $update->execute ($params);
        }
        
        public function forgotPass($params)
        {
            $update = $this->db->prepare("
                UPDATE `user` SET `password` = :password WHERE :id_user = `id_user`
            ");
            return $update->execute ($params);
        }
    }

?>
        