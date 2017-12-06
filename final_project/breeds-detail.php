<!-- variables -->

<?php
include('top.php');


/*CSV TABLE*/
$breedSelection = '';
if(isset($_GET['breedSelection'])){
    $breedSelection = htmlentities($_GET['breedSelection'], ENT_QUOTES, "UTF-8");
}
// **************Open a CSV file********************
$debug = false;
if(isset($_GET["debug"])){
     $debug = true; 
}

$myFolder = 'data/';

$myFileName = 'breeds-detail';

$fileExt = '.csv';

$filename = $myFolder . $myFileName . $fileExt;

if ($debug) print '<p>filename is ' . $filename;

$file=fopen($filename, "r");

if($debug){
    if($file){
       print '<p>File Opened Succesful.</p>';
    }else{
       print '<p>File Open Failed.</p>';
     }
}
// *****************end open data********************

// ***************Read weather data*****************

if($file){
    if($debug) print '<p>Begin reading data into an array.</p>';

    // read the header row, copy the line for each header row
    // you have.

     // read all the data
     while(!feof($file)){
         $breedDatas[] = fgetcsv($file);
     }

     if($debug) {
         print '<p>Finished reading data. File closed.</p>';
         print '<p>My data array<p><pre> ';
         print_r($breedDatas);
         print '</pre></p>';
     }
} // *************ends if file was opened**************** 

// end read weather data

fclose($file);

?>

    <!-- <h2>Photos</h2> -->
        <?PHP
        
        foreach ($breedDatas as $breedData) {
            if ($breedSelection == $breedData[3]) {
                print '<a href ="form.php">';
                print '<figure class ="">';
                print '<img src=' . '"' . $breedData[1] . '"  class="dogs" ' . "alt=" . '"'. $breedData[2] .'">';
                print '<figcaption>' . $breedData[2] . '</figcaption>';
                print '</figure>';
                print '</a>';
                print'<br/>';
            
            }
        }
        include('footer.php');
        ?>
    </body>
</html>