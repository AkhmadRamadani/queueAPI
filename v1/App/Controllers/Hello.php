<?php

// *
// *    Hello Controller
// *    Author: Alfan Hidayatullah
// *

// Get route
$this->get ('', \Hello::class . ":index");
$this->get ('/myname/{name}', \Hello::class . ":name");
$this->get ('/myname', \Hello::class . ":myName");
$this->get ('/list', \Hello::class . ":get");

// Post Route
$this->post('/myname', \Hello::class . ":postMyName");
$this->post('/new', \Hello::class . ":addNew");

class Hello extends Queue {


    // *
    // *    @GET Index Method
    // *
    public function index ( $request, $response, $args ) {

        // Return feedback data
        return $response->withJSON ( array (
            "status"    => true,
            "message"   => "Hello world"
        ));

    }


    // *
    // *    @GET Name Method
    // *    args: name
    // *
    public function name ( $request, $response, $args ) {

        // Get args
        $this->args     = $args;

        // Return feedback data
        return $response->withJSON ( array (
            "status"    => true,
            "message"   => "Hello " . $this->args["name"]
        ));

    }


    // *
    // *    @GET MyName Method
    // *    params: name
    // *
    public function myName ( $request, $response, $args ) {

        // Get request params
        $this->params   = $request->getQueryParams();

        // Return feedback data
        return $response->withJSON ( array (
            "status"    => true,
            "message"   => "Hello " . $this->params["name"]
        ));

    }


    // *
    // *    @POST PostMyName Method
    // *    params: name
    // *
    public function postMyName ( $request, $response, $args ) {

        // Get request params
        $this->params   = $request->getParsedBody();

        // Return feedback data
        return $response->withJSON ( array (
            "status"    => true,
            "message"   => "Hellooo " . $this->params["name"]
        ));

    }


    // *
    // *    @POST Add New Method
    // *    params: name
    // *
    public function addNew ( $request, $response, $args ) {

        // Get request params
        $this->params   = $request->getParsedBody();

        // Initialize model
        $this->initModel ( "hello" );

        // Insert data
        $insert = $this->helloModel->insert ( array (
            ":name" => $this->params["name"]
        ));

        // if Insert success
        if ( $insert ) {
            // Return feedback data
            return $response->withJSON ( array (
                "status"    => $insert,
                "message"   => "Hellooo " . $this->params["name"],
                "data"      => array (
                    "id"    => $this->helloModel->lastInsertId (),
                    "name"  => $this->params["name"],
                )
            ));
        }

        // If failed
        return $response->withJSON ( array (
            "status"    => $insert,
            "message"   => "Insert failed"
        ));

    }


    // *
    // *    @POST Get Method
    // *    params: name
    // *
    public function get ( $request, $response, $args ) {

        // Initialize model
        $this->initModel ( "hello" );

        // Insert data
        $data = $this->helloModel->get ();

        // Return feedback data
        return $response->withJSON ( array (
            "status"    => ( sizeof ($data) > 0 ),
            "message"   => "Success fetching data",
            "data"      => $data
        ));

    }


}

?>
