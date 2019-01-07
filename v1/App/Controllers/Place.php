<?php

    $this->post ('/placeReg', \Place::class . ":placeRegister");
    $this->post ('/updateQueueStatus', \Place::class . ":updateQueueStatus");
    $this->post ('/updatePlaceStatus', \Place::class . ":updatePlaceStatus");
    $this->post ('/getQueue', \Place::class . ":getQueue");
    $this->post ('/cancelQueue', \Place::class . ":cancelingQueue");
    $this->post ('/getMyPlaceQueue', \Place::class . ":getMyPlaceQueue");
    $this->post ('/getMyQueue', \Place::class . ":getMyQueue");
    $this->post ('/search', \Place::class . ":searchPlace");
    $this->get ('/openPlace', \Place::class . ":getOpenPlace");
    class Place extends Queue
    {
        public function placeRegister($request, $response, $args)
        {
            
        $picture='';
        $uploadedfile = $_FILES['picture']['tmp_name'];
            
            $filename = $_FILES['picture']['name'];

            $extension = getExtension($filename);

            $extension = strtolower($extension);
            if(($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")){

                $json = array("message" => 'error',"code"=>500);
                return;
            }else{
                $size=filesize($uploadedfile);
                if($extension == "jpg" || $extension == "jpeg"){

                    $src = imagecreatefromjpeg($uploadedfile);

                }else if($extension == "png"){

                    $src = imagecreatefrompng($uploadedfile);

                }else{

                    $src = imagecreatefromgif($uploadedfile);

                }
                list($width,$height)=getimagesize($uploadedfile);
                $imratio = 1;
                if($width != 0 && $height != 0)
                    $imratio = $width/$height;
                $imgNameRand = basename(microtime(true).".".$extension);
                $tmp=imagecreatetruecolor($width,$height);
                imagecopyresampled($tmp,$src,0,0,0,0,$width,$height,$width,$height);
                $filename = "./place/". $imgNameRand;
                imagejpeg($tmp, $filename, 100);

                imagedestroy($src);
                imagedestroy($tmp);
            }
            //
            //

            $this->params = $request->getParsedBody();
            $this->initModel('place');

                $insert = $this->placeModel->getRegisterPlace (array(
                    ":name" => $this->params['name'],
                    ":address" => $this->params['address'],
                    ":picture" => $filename,
                    ":id_user" => $this->params['id_user']
                ));
                if($insert){
                    return $response->withJSON(array(
                        "status" => true,

                    ));
                }
                return $response->withJSON(array(
                    "status" => false,
                    "message" => 'register gagal'
                ));
        }

        public function getQueue($request, $response, $args){

            $this->params = $request->getParsedBody();
            $this->initModel('place');

                $insert = $this->placeModel->getQueue (array(
                    ":id_place" => $this->params['id_place'],
                    ":id_user" => $this->params['id_user'],
                    ":queue_code" => $this->params['queue_code'],
                    ":status" => $this->params['status']
                ));
                if($insert){
                    return $response->withJSON(array(
                        "status" => true,

                    ));
                }
                return $response->withJSON(array(
                    "status" => false,
                    "message" => 'register gagal'
                ));

        }
        public function updatePlaceStatus($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('place');

            $insert = $this->placeModel->updatePlaceStatus(array(
                ":id_place" => $this->params['id_place'],
                ":status" => $this->params['status']
            ));
            if($insert){
                return $response->withJSON(array(
                    "status" => true,

                ));
            }
            return $response->withJSON(array(
                "status" => false,
                "message" => 'update gagal'
            ));
        }
        public function cancelingQueue($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('place');

            $insert = $this->placeModel->cancelingQueue(array(
                ":queue_code" => $this->params['queue_code']
            ));
            if($insert){
                return $response->withJSON(array(
                    "status" => true,

                ));
            }
            return $response->withJSON(array(
                "status" => false,
                "message" => 'cancel gagal'
            ));
        }
        public function getOpenPlace($request , $response , $args)
        {
            $this->initModel('place');
            $select = $this->placeModel->getOpenPlace();
            return $response->withJSON(array(
                "data" => $select
            ));
        }
        public function getMyQueue($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('place');
            $select = $this->placeModel->getMyQueue(array(
                ':id_user' => $this->params['id_user']
            ));
            return $response->withJSON(array(
                "data" => $select
            ));
        }
        public function getMyPlaceQueue($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('place');
            $select = $this->placeModel->getMyPlaceQueue(array(
                ':id_place' => $this->params['id_place']
            ));
            return $response->withJSON(array(
                "data" => $select
            ));
        }
        public function updateQueueStatus($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('place');

            $insert = $this->placeModel->updateQueueStatus(array(
                ":id_queue" => $this->params['id_queue'],
                ":status" => $this->params['status']
            ));
            if($insert){
                return $response->withJSON(array(
                    "status" => true,

                ));
            }
            return $response->withJSON(array(
                "status" => false,
                "message" => 'update gagal'
            ));
        }
        public function searchPlace($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('place');
            $select = $this->placeModel->searchPlace(array(
                ':name' => $this->params['name']
            ));
            return $response->withJSON(array(
                "data" => $select
            ));
        }
    }

    
?>