<?php




class Filter extends Queue { 


    /**
     * 
     * Middleware Invoke Function 
     * 
     */
    public function __invoke ( $request, $response, $next ) {

        if ( ! isset ( $request->getHeader ( 'HTTP_AUTHORIZATION' ) [0] ) ) {
            return $response->withJSON ( array ( "status" => false, "message" => "Ilegal access!" ) );
        }

        $authData = str_replace ( "Bearer ", "", $request->getHeader ( 'HTTP_AUTHORIZATION' ) [0] );

        $jsonData = json_decode ( $authData ); 

        $result = $this->getAuth ( $jsonData->userId, $jsonData->token );

        if ( ! is_null ( $result ) ) {

            return $response->withJSON ( $result );
        }

        return $next ( $request, $response );
    }


    /**
     * 
     * Get Authentication Data
     * 
     */
    public function getAuth ( $userId, $token ) {

        $this->initModel ( "userSecret" );
        
        $secretData = $this->userSecretModel->getUserSecret ( array (
            ":user_id" => $userId
        ));

        $tokenAll = explode ( ":", $secretData["token"] );

        if ( sizeof ( $secretData ) == 0 ) {
            
            return array ( "status" => false, "message" => "404 not found!" );
        }

        else if ( ! in_array ( $token, $tokenAll ) ) {

            return array ( "status" => false, "message" => "Token missmatach!" );
        }

        return null;
    }

}