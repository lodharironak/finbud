<?php /* Template Name: chron */ get_header();
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

global $wpdb;

    /*Code for log of cron running*/
        // Get the current web URL
        $currentWebURL = esc_url(home_url($_SERVER['REQUEST_URI']));        
    
        // Get the current date and time
        $currentDateTime = current_time('Y-m-d H:i:s');
    
        // Get the browser information
        $browserInfo = $_SERVER['HTTP_USER_AGENT'];    
    
        // Format the log message
        $logMessage = "Web URL: ".$currentWebURL."\nDate & Time: ".$currentDateTime."\nBrowser Info: ".$browserInfo."\n\n";

        $logtablename = 'cronlog';

        $data = array('log' => $logMessage);
        $inserted = $wpdb->insert($logtablename, $data);
        

    /*Code for log of cron running*/
$theme_url = get_template_directory_uri();
$languageWiseURL['en'] = $theme_url.'/google_runnerslab_EN.xml';
// $languageWiseURL['en'] = 'https://tilroy.s3.eu-west-1.amazonaws.com/175/feed/google_runnerslab_EN.xml';
// $languageWiseURL['nl'] = 'https://tilroy.s3.eu-west-1.amazonaws.com/175/feed/google_runnerslab_NL.xml';

// Download files and save the data in the database.

foreach ($languageWiseURL as $url) {
    $data = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
 // $xmlString = file_get_contents($url);
   
    foreach ($data->channel->item as $row) {

        $childrens = $row->children('g', true);
        echo "<pre>";
        print_r($childrens);
        echo "</pre>";
        /*echo "<pre>";print_r($childrens->id);echo "</pre>";exit;*/
        try {
            // Check if the id is empty or not
            if (!empty($childrens->id)) {
                //Check if the id exists in the database or not 
                $result = $wpdb->get_results("SELECT * FROM products WHERE p_id =" . $childrens->id);
                //echo "<pre>";print_r($wpdb);echo "</pre>";exit;
                if ($wpdb->num_rows > 0) {
                    // Update the record if already exists

                    /*$wpdb->query($wpdb->prepare("UPDATE 'products' 
                            SET 'title' = $childrens->title,'description' = $childrens->description, 'category' = $childrens->category, 'link' = $childrens->link, 'image_link' = $childrens->image_link, 'price' = $childrens->price, 'brand' = $childrens->brand where 'p_id' = $childrens->id"));*/

                    $wpdb->query($wpdb->prepare("UPDATE products 
                            SET 'title' = $childrens->title,'description' = $childrens->description, 'category' = $childrens->product_type, 'link' = $childrens->link, 'image_link' = $childrens->image_link, 'price' = $childrens->price, 'brand' = $childrens->brand where p_id = $childrens->id"));
                } else {
                    // insert new record 

                    $tablename = 'products';

                    $data = array(
                        'p_id' => !empty(((array)$childrens->id)) ? ((array)$childrens->id)[0] : NULL,
                        'title' => !empty(((array)$childrens->title)) ? ((array)$childrens->title)[0] : NULL,
                        'description' => !empty(((array)$childrens->description)) ? ((array)$childrens->description)[0] : NULL,
                        //'category' => !empty(((array)$childrens->category)[0]) ? ((array)$childrens->category)[0] : NULL,
                        'category' => !empty(((array)$childrens->product_type)[0]) ? ((array)$childrens->product_type)[0] : NULL,
                        'link' => !empty(((array)$childrens->link)[0]) ? ((array)$childrens->link)[0] : NULL,
                        'image_link' => !empty(((array)$childrens->image_link)[0]) ? ((array)$childrens->image_link)[0] : NULL,
                        'price' => !empty(((array)$childrens->price)[0]) ? ((array)$childrens->price)[0] : NULL,
                        'brand' => !empty(((array)$childrens->brand)[0]) ? ((array)$childrens->brand)[0] : NULL
                    );
                    $inserted = $wpdb->insert($tablename, $data);
                    //echo "<pre>";print_r($wpdb);exit;
                }
            }
        } catch (\Exception $e) {
            echo 'Error message: ' . $e->getMessage() . ' and error at line: ' . $e->getLine();
        }
    }
    // exit;
}


get_footer();
