<?php 

    $this->post ('/register', \Auth::class . ":authRegister");
    $this->post ('/updateProfil', \Auth::class . ":updateProfil");
    $this->post ('/login', \Auth::class . ":authLogin");
    $this->post ('/forgotPass', \Auth::class . ":forgotPass");
    $this->post ('/beforeForgetPass', \Auth::class . ":beforeForgetPass");

    class Auth extends Queue {
        public function authLogin ( $request, $response, $args ) {

            $this->params = $request->getParsedBody();
            $this->initModel ( "auth" );
            $data = $this->authModel->getLoginData (array(
                ":email" => $this->params['email'],
                ":password" => $this->encrypt_password($this->params)
            ));
            if($data){
                return $response->withJSON(array(
                    "status" => true,
                    "data" => $data
                ));
            }
            return $response->withJSON(array(
                "status" => false
            ));
    
        }
        
        public function authRegister($request, $response, $args)
        {    
            $this->params = $request->getParsedBody();
            $this->initModel('auth');
            
            $data = $this->authModel->checkEmail(array(
             ":email" => $this->params['email'],
             ));

            if($data){
                return $response->withJSON(array(
                    "status" => false,
                    "message" => 'email sudah ada'
                ));
            }
            else{
                $insert = $this->authModel->getRegisterData (array(
                    ":name" => $this->params['name'],
                    ":email" => $this->params['email'],
                    ":password" => $this->encrypt_password($this->params)
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

        }
        public function updateProfil($request , $response , $args)
        {
            $photoprofile='';
            $uploadedfile = $_FILES['photoprofile']['tmp_name'];
            
            $filename = $_FILES['photoprofile']['name'];

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
                $filename = "./profile/". $imgNameRand;
                imagejpeg($tmp, $filename, 100);

                imagedestroy($src);
                imagedestroy($tmp);
            }

            $this->params = $request->getParsedBody();
            $this->initModel('auth');

            $insert = $this->authModel->updateProfil(array(
                ":id_user" => $this->params['id_user'],
                ":name" => $this->params['name'],
                ":email" => $this->params['email'],
                ":password" => $this->encrypt_password($this->params),
                ":photoprofile" => $filename
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
        public function beforeForgetPass($request, $response, $args)
        {    
            $this->params = $request->getParsedBody();
            $this->initModel('auth');
            
            $data = $this->authModel->beforeForgetPass(array(
             ":email" => $this->params['email'],
             ));

            if($data){
                return $response->withJSON(array(
                    "status" => true,
                    "data" => $data
                ));
            }
        }
        public function forgotPass($request , $response , $args)
        {
            $this->params = $request->getParsedBody();
            $this->initModel('auth');

            $insert = $this->authModel->forgotPass(array(
                ":id_user" => $this->params['id_user'],
                ":password" => $this->encrypt_password($this->params)
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
    }
    
    function getExtension($fname){
        $pos = strrpos($fname,".");
        if (!$pos) {return "";}
        $end = strlen($fname) - $pos;
        $ext = substr($fname,$pos+1,$end);
        return $ext;
    }

?>