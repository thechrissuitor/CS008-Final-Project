<!-- variables -->

<?php
include('top.php');


/*CSV TABLE*/
$breedData = '';
if(isset($_GET['breedData'])){
    $artData = htmlentities($_GET['breedData'], ENT_QUOTES, "UTF-8");
}
// **************Open a CSV file********************
$debug = false;
if(isset($_GET["debug"])){
     $debug = true; 
}

$myFolder = 'data/';

$myFileName = 'breeds';

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
      
            <h2>Categories</h2>
        <?php
        
        
        print '<table>';


        $count = 2;
        foreach ($breedDatas as $breedData) {
            $breedSelection = '';
            
            if($count%2==0){
                print '<tr>';
            }
            print '<td>';
            
            print '<a href="breeds-detail.php?breedSelection=';
            print str_replace(' ', '', $breedData[3]);
            print '">';
            
            print '<figure >';
            print '<img src=' . '"' . $breedData[1] . '"  class="" ' . "alt=" . '"'. $breedData[2] .'">';
            print '<figcaption>' . $breedData[2] . '</figcaption>';
            print '</figure>';
            
            print'</a></td>';
            
            if($count%2==1){
                print '</tr>';
            }
            $count++;
        }

        print'</table>';

        
        
include('footer.php');
?>        
    </body>
</html>