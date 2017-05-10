<?php

    /*enterMessage
        
    */
    function enterMessage($author,$mess,$dbhandle) {
        $query = "Insert into messages(author, content) values ('".$author."','".$mess."'";
        
        $statement = $dbhandle -> prepare($query);
        $statement->execute();
    }

    /*getMessages
    queries the database for all messages so far
    returns messages in json:
    {"author":"the_users_name", "content":"the text content of their message"}
    */
    function getMessages($dbhandle) {
    
        $query = "SELECT * FROM messages";

        $statement = $dbhandle->prepare($query);

        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
       
    }

    $dbhandle = new PDO("sqlite:mess.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
   
      
      $errors         = array();
    $data 			= array();
    
    if (empty($_POST['message']))
		$errors['alert'] = 'Message is required.';
		
	if ( ! empty($errors)) {
		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {
		// if there are no errors process our form, then return a message
		// DO ALL YOUR FORM PROCESSING HERE
		// THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)
		// show a message of success and provide a true success variable
		 /* 
     * I want to recieve any type of request. 
     * This API will parrot back the VERB,
     * the PAYLOAD you sent,
     * and the REQUEST (api/:something/:else/:here will spit out [":something",":else",":here"])
     * as a json object
     */
    //$_SERVER is a super global
      $verb = $_SERVER["REQUEST_METHOD"];
      
    /* 
     * I like using StdClass in PHP it is the default Object, 
     * instead of object.attribute you use object->attribute.  
     * That is largely because "string1"."string2" is how you concatenate in PHP.
     */
      $response = new StdClass();
      //$response->verb = $verb;
      //$response->request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
    /*
     * $_GET and $_POST are the ways of getting the parameters in the standard case, but 
     * php://input is how you get the JSON data out of PUT, DELETE, PATCH, OPTIONS, etc.
     *
     * $_GET["key"] will spit out "value" if key and value were sent along.
     */
      switch ($verb) {
        case 'GET':    
          $resp = getMessages($dbhandle);
          $response->payload = $resp;
          echo json_encode($response);
          break;
        case 'POST':
          $response->payload = $_POST;
          //echo json_encode($response);
          break;
      };
		$data['success'] = true;
		$data['alert'] = 'Success!';
	}
	// return all our data to an AJAX call
	echo json_encode($data);
   /*function getUsername {
        if(!$_SESSION['username']) 
    };*/
    //The results of the query are typically many rows of data
    //there are several ways of getting the data out, iterating row by row,
    //I chose to get associative arrays inside of a big array
    //this will naturally create a pleasant array of JSON data when I echo in a couple lines
    // $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it back to the browser
    //echo json_encode($results);
?>