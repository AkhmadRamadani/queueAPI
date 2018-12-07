<?php

class Remap {
    
    const REL_NOTHING    = "0";
    const REL_REQ_KEPO   = "1";
    const REL_REQ_FRIEND = "2";
    const REL_RQD_KEPO   = "3";
    const REL_RQD_FRIEND = "4";
    const REL_KEPO       = "5";
    const REL_KEPOED     = "6";
    const REL_FRIEND     = "7";

    const PHOTO_THUMBNAIL   = 30;
    const PHOTO_SMALL_SIZE  = 160;
    const PHOTO_MEDIUM_SIZE = 480;
    const PHOTO_BIG_SIZE    = 720; 

    const UPLOAD_PATH               = "../../../storage/";
    const UPLOAD_URI                = "storage/";
    const UPLOAD_POST_PATH          = "../../storage/posts/";
    const UPLOAD_POST_URI           = "storage/posts/";
    const UPLOAD_COVER_PATH         = "../../storage/cover/";
    const UPLOAD_COVER_URI          = "storage/cover/";
    const UPLOAD_PROFILE_PATH       = "../../storage/profile/";
    const UPLOAD_PROFILE_URI        = "storage/profile/";
    const UPLOAD_STICKER_PATH       = "../../storage/sticker/";
    const UPLOAD_STICKER_URI        = "storage/sticker/";
    const UPLOAD_LOUNGE_COVER_PATH  = "../../storage/lounge/cover/";
    const UPLOAD_LOUNGE_COVER_URI   = "storage/lounge/cover/";
    const UPLOAD_LOUNGE_PHOTO_PATH  = "../../storage/lounge/photo/";
    const UPLOAD_LOUNGE_PHOTO_URI   = "storage/lounge/photo/";
    const UPLOAD_BANNER_PATH        = "../../storage/banners/";
    const UPLOAD_BANNER_URI         = "storage/banners/";
    const UPLOAD_REPORT_PATH        = "../../storage/report/";
    const UPLOAD_REPORT_URI         = "storage/report/";
    const UPLOAD_MEDIA_PATH         = "../../storage/media/";
    const UPLOAD_MEDIA_URI          = "storage/media/";

    const BASIC_POST_KIND       = 0;
    const IMAGE_POST_KIND       = 1;
    const LOCATION_POST_KIND    = 2;
    const SHARE_POST_KIND       = 3;
    const KABAR_POST_KIND       = 4;
    const ACADEMY_POST_KIND     = 5;
    const KIOS_POST_KIND        = 6;
    const COMMENT_POST_KIND     = 9;
    const AL_POST_KIND          = 10;

    const FB_APP_ID     = '283666898713960'; //Facebook App ID
    const FB_APP_SECRET = '37a177b5ca881909cdeeca06fbd1e103'; //Facebook App Secret
    

    public $tempMsg = ""; 

    public $args   = array();
    public $params = array();



    public function __construct () { 

        global $config;

        $database = new Database ( $config["db"] );

        $this->db = $database->get ();
    }
    
    /**
     *
     *  Model Initialization
     *  
     **/
    public function initModel ( $model ) {

        $modelName = $model . "Model";

        require_once ( REMAP_BASE . "App/Models/" . $model . ".php" ); // Main System

        $this->$modelName = new $modelName ();
    }

    
    /**
     *
     *  Helper Initialization
     *  
     **/
    public function initHelper( $helper ) {

        $helper = strtolower ( $helper );
        $helper_name = $helper . "Helper";

        $helperObject = ucfirst ( $helper ) . "Helper";

        require_once ( REMAP_BASE . "App/Helpers/" . ucfirst ( $helper ) . ".php" ); // Main System

        $this->$helper_name = new $helperObject ();
    }

    
    /**
     *
     *  Sibling Controller Initialization
     *  
     **/
    public function initSiblingController ( $controller ) {

        $controller_name = $controller . "Controller";

        $controller = ucfirst ( $controller );
        
        require_once ( REMAP_BASE . "App/Controllers/" . $controller . ".php" ); // Main System

        $this->$controller_name = new $controller ();
    }


    /**
     *
     *  Controller Initialization
     *  
     **/
     public function initController ( $controller ) {
        
        $this->initSiblingController ( $controller );
    }


    /**
     * 
     * Get Authorization Data
     * 
     */
    public function setAuth ( $request ) {

        $authData = str_replace ( "Bearer ", "", $request->getHeader ( 'HTTP_AUTHORIZATION' ) [0] );

        $this->auth = json_decode ( $authData );
    }


    /**
     *
     *  Password Encryption
     *  
     **/
    public function encrypt_password( $params ) {
 
        if ( isset( $params["password"] ) ) {

            return hash( "sha256", "pamer". $params["password"] . "pamer" );
        }
    }

    /**
     *
     *  User Token Generate
     *  
     **/
    public function generate_token($params) {

        return md5 ( "pamer" . date("dmyHis") . $params["user_id"] . "pamer" );
    }


    /**
     *
     *  Remap Current Version
     *  
     **/
    public function versions( $request, $response, $args ) {

        return $response->withJSON( array (
            "version_code"  => 1,
            "content"       => "Version 1.0",
            "forceUpdate"   => false
        ));  
    }

}