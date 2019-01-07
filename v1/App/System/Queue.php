<?php

class Queue {
    
    const PHOTO_THUMBNAIL   = 30;
    const PHOTO_SMALL_SIZE  = 160;
    const PHOTO_MEDIUM_SIZE = 480;
    const PHOTO_BIG_SIZE    = 720;     

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

        require_once ( QUEUE_BASE . "App/Models/" . $model . ".php" ); // Main System

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

        require_once ( QUEUE_BASE . "App/Helpers/" . ucfirst ( $helper ) . ".php" ); // Main System

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
        
        require_once ( QUEUE_BASE . "App/Controllers/" . $controller . ".php" ); // Main System

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

            return hash( "md5", "queue". $params["password"] . "queue" );
        }
    }

    /**
     *
     *  User Token Generate
     *  
     **/
    public function generate_token($params) {

        return md5 ( "queue" . date("dmyHis") . $params["user_id"] . "queue" );
    }


    /**
     *
     *  Queue Current Version
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