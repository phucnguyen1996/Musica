<?php

include 'config.php';


$display = 24; // nb albums displayed in a page
$num_links = 3;          

// calcul total rows of db
$result = $pdo->query($queryCount); 
list( $total_rows ) = $result->fetch(3);
   

// get page
if(isset($_GET['page']) && is_numeric($_GET['page']))
      $curr_page = $_GET['page'];

else
     //nếu không tồn tại trang thì mặc nhiên sẽ là trang 1
     $curr_page = 1;
            
// calcul the star position for LIMIT and total pages
$position = ($curr_page - 1) * $display;
$endPosition = $position + $display ;

$total_pages = ceil($total_rows / $display);

if($curr_page > $num_links)
   $start = $curr_page - ($num_links - 1);
else
    $start = 1;
    
$end = $total_pages ;
if(($curr_page + $num_links ) < $total_pages)
{
    $end = $curr_page + $num_links;
}
?>                                    