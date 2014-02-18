<?php
    // Defining the basic cURL function
    function curl($url) {
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }

	// Defining the basic scraping function
    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }


$scraped_website = curl("http://sanantonio.craigslist.org/search/sof?query=+");  

// Executing our curl function to scrape the webpage http://www.example.com and return the results into the $scraped_website variable

// echo $scraped_website;

$continue = TRUE;   // Assigning a boolean value of TRUE to the $continue variable
     
    $url = "http://sfbay.craigslist.org/search/sof/pen?zoomToPosting=&catAbb=sof&query=php&excats=";    // Assigning the URL we want to scrape to the variable $url
     
    // While $continue is TRUE, i.e. there are more search results pages
//    while ($continue == TRUE) {
         
        $results_page = curl($url); // Downloading the results page using our curl() funtion
 
        $results_page = scrape_between($results_page, '<div class="content">', "</div>"); // Scraping out only the middle section of the results page that contains our results
         
        $separate_results = explode('</p>', $results_page);   // Exploding the results into separate parts into an array
         
        // var_dump($separate_results); 
        // For each separate result, scrape the URL
        //foreach ($separate_results as $separate_result) {
        //    if ($separate_result != "") {
        //        $results_urls[] = "http://www.imdb.com" . scrape_between($separate_result, "href=\"", "\" title="); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
        //    }
        // }
 
        // Searching for a 'Next' link. If it exists scrape the url and set it as $url for the next loop of the scraper
        // if (strpos($results_page, "Next&nbsp;&raquo;")) {
        //     $continue = TRUE;
        //     $url = scrape_between($results_page, "<span class=\"pagination\">", "</span>");
        //     if (strpos($url, "Prev</a>")) {
        //         $url = scrape_between($url, "Prev</a>", ">Next");
        //     }
        //     $url = "http://www.imdb.com" . scrape_between($url, "href=\"", "\"");
        // } else {
        //     $continue = FALSE;  // Setting $continue to FALSE if there's no 'Next' link
        // }
 //       sleep(rand(50,60));   // Sleep for 3 to 5 seconds. Useful if not using proxies. We don't want to get into trouble.
 //   }

foreach ($separate_results as $result) {
	$link = scrape_between($result, 'href="','"');
	//var_dump($link);
	$date = scrape_between($result, 'date', '</');
	//var_dump($date);

	$linkArray[] = array('link'=>('http://sfbay.craigslist.org'.$link), 'date'=>$date);

}

var_dump($linkArray)

?>