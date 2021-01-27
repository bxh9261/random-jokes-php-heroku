<?php
	/*
		Name: get-jokes.php
		Description: Returns an array of random jokes in JSON format
		Author: 
		Last Modified: 
		Example usage: get-jokes.php?limit=3
	*/
	
	// I. define some constants
	define('MIN_LIMIT', 1); 
	define('MAX_LIMIT', 44); 
	
	
	// II. $jokes contains our data
	// this is an indexed array of associative arrays
	// the associative arrays are jokes -  they have an 'q' key and an 'a' key
	$jokes = [
		["q" => "Comment appelez-vous un très petit valentine?", "a" => "Un valen-tiny!"],
		["q" => "Qu'est-ce que le chien a dit en se frottant la queue sur le papier de verre?", "a" => "Ruff, Ruff!"],
		["q" => "Pourquoi les requins n'aiment-ils pas manger des clowns?", "a" => "Parce qu'ils ont un goût drôle!"],
		["q" => "Qu'est-ce que le petit chat a dit à la petite chatte?", "a" => "Vous êtes ronronnement!"],
		["q" => "Quel est le sport extérieur préféré d'une grenouille?", "a" => "Pêche à la mouche!"],
		["q" => "Je déteste les blagues sur les saucisses allemandes.", "a" => "Ils sont la wurst."],
		["q" => "Avez-vous entendu parler de la fromagerie qui a explosé en France?", "a" => "Il ne restait plus que de Brie."],
		["q" => "Notre mariage était si beau", "a" => "Même le gâteau était en étages."],
		["q" => "Cette piscine est-elle sûre pour la plongée?", "a" => "Elle se termine profondément."],
		["q" => "Papa, peux-tu mettre mes chaussures?", "a" => "Je ne pense pas qu'elles me conviendront."],
		["q" => "Est-ce que février mars?", "a" => "Non, mais avril mai"],
		["q" => "Qu'est-ce qui se trouve au fond de l'océan et qui secoue?", "a" => "Une épave nerveuse."],
		["q" => "Je lis un livre sur l'histoire de la colle.", "a" => "Je n'arrive tout simplement pas à le poser."],
		["q" => "Papa, peux-tu mettre le chat dehors?", "a" => "Je ne savais pas qu'il était en feu."],
		["q" => "Qu'est-ce que l'océan a dit au voilier?", "a" => "Rien, il a juste agité."],
		["q" => "Qu'est-ce que vous obtenez lorsque vous croisez un bonhomme de neige avec un vampire?", "a" => "Engelures"]
	]; 
	
	
	// III. Sanitize the `limit` parameter to be sure that it is numeric, and is not too small or large
	$limit = MIN_LIMIT; // the default
	if(array_key_exists('limit', $_GET)){ // if there is a `limit` parameter in the query string
		$limit = $_GET['limit'];
		$limit = (int)$limit; // explicitly cast value to an integer
		$limit =  ($limit < 1) ? MIN_LIMIT : $limit; // PHP has a ternary operator too
		$limit =  ($limit > MAX_LIMIT) ? MAX_LIMIT : $limit; // PHP has a ternary operator too
	}
	
	
	// IV. Do a final check that there are enough jokes in the $jokes array
	if($limit > count($jokes)){
		$limit = count($jokes);
	}
	
	
	// V. get a random element of the $jokes array
	// there are a bunch more PHP array functions at: http://php.net/manual/en/ref.array.php
	// https://www.php.net/manual/en/function.shuffle.php
	// https://www.php.net/manual/en/function.array-push.php
	$randomKeys = array_keys($jokes); // creates an array of indexes - something like [0,1,2,3,4,5,6,7,...]
	shuffle($randomKeys); // randomizes the $randomKeys array - something like [1,5,3,2,0,8,4,7,6, ...]
	$randomKeys = array_slice($randomKeys, 0, $limit); // just get the first `n` number of indexes we need
	$randomJokes = []; // the random jokes will go here
	foreach($randomKeys as $key){ // loop through $randomKeys
 		array_push($randomJokes,$jokes[$key]); // add a random joke to the array
 	}
	
	
	// VI. Send HTTP headers
	// https://www.php.net/manual/en/function.header.php
	// DO THIS **BEFORE** you `echo()` the content!
	header('content-type:application/json');      			// tell the requestor that this is JSON
	header('Access-Control-Allow-Origin: *');     			// turn on CORS
	header('X-this-430-service-is-kinda-lame: true');   // a custom header 
    header('X-author-name: bee');
	
	
	// VII. Send the content
	// json_encode() turns a PHP associative array into a string of well-formed JSON
	// https://www.php.net/manual/en/function.json-encode.php
	$string = json_encode($randomJokes);
	echo $string;

?>
