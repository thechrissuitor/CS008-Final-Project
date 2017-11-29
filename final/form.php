<?php
include 'top.php';
//%^^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variable
//
// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){ // later you can uncomment the if statement
//print '<p>Post Array:</p><pre>';
//print_r($_POST);
//print '</pre>';
// }

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.

$thisURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variable one for each form element
// in the order they appear on the form

$firstName = "";

$lastName = "";

$email = "";

$pets = "";

$experience = "";

$house = false; //not checked

$condo = false; //not checked

$apartment = false; //not checked

$owner = false; //not checked

$rent = false; //not checked

$shade = "";

$shadeType = "";

$fenced = "";

$breed = "None";

$comments = "";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags for each form elment we validate
// in the order they appear in section 1c.
$firstNameERROR = false;

$lastNameERROR = false;

$emailERROR = false;

$petsERROR = false;

$experienceERROR = false;

$housingERROR = false;
$totalHousingChecked = 0;

$shadeERROR = false;

$shadeTypeERROR = false;

$fencedERROR = false;

$breedERROR = false;

$commentsERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// array used to hold form values that will be written to a CSV files
$dataRecord = array();

// have we mailed the information to the user?
$mailed = false;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if(isset($_POST["btnSubmit"])){

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    //
if(!securityCheck($thisURL)){
    $msg = '<p>Sorry you cannot access this page. ';
    $msg.= 'Security breach detected and reported.</p>';
    die($msg);
}


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data
    // remove any potential JavaScript or html code from user's input on the
    // form. Note it is best to follow that same order as declared in section 1c.

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
    
    $pets = filter_var($_POST["radPets"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $pets;
    
    $experience = filter_var($_POST["radExperience"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $experience;
    
    if(isset($_POST["chkHouse"])) {
        $house = true;
        $totalHousingChecked++;
    } else {
        $house = false;
    }
    $dataRecord[] = $house;
    
    if(isset($_POST["chkCondo"])) {
        $condo = true;
        $totalHousingChecked++;
    } else {
        $condo = false;
    }
    $dataRecord[] = $condo;
    
    if(isset($_POST["chkApartment"])) {
        $apartment = true;
        $totalHousingChecked++;
    } else {
        $apartment = false;
    }
    $dataRecord[] = $apartment;
    
    if(isset($_POST["chkOwner"])) {
        $owner = true;
        $totalHousingChecked++;
    } else {
        $owner = false;
    }
    $dataRecord[] = $owner;
    
    if(isset($_POST["chkRent"])) {
        $rent = true;
        $totalHousingChecked++;
    } else {
        $rent = false;
    }
    $dataRecord[] = $rent;
    
    $shade = filter_var($_POST["radShade"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $shade;
    
    $shadeType = htmlentities($_POST["txtShadeType"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $shadeType;
    
    $fenced = filter_var($_POST["radFenced"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $fenced;
    
    $breed = htmlentities($_POST["lstBreed"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $breed;
    
    $comments = htmlentities($_POST['txtComments'], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.
    if($firstName == ""){
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra charactrs";
        $firstNameERROR = true;
    }
    
    if($lastName == ""){
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra characters";
        $lastNameERROR = true;
    }

    if($email == ""){
        $errorMsg[] ='Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = 'Your email address appears to be incorrect';
        $emailERROR = true;
    }
    
    if($pets == ""){
        $errorMsg[] = "Please select an option about your pets";
        $petsERROR = true;
    } elseif (!verifyAlphaNum($pets)) {
        $errorMsg[] = "It seems you have altered our pets buttons";
        $petsERROR = true;
    } elseif ($pets != 'Yes' AND $pets != 'No') {
        $errorMsg[] = "It seems you have altered our pets buttons";
        $petsERROR = true;
    }
    
    if($experience == ""){
        $errorMsg[] = "Please select an option on your experience";
        $experienceERROR = true;
    } elseif (!verifyAlphaNum($experience)) {
        $errorMsg[] = "It seems you have altered our experience buttons";
        $experienceERROR = true;
    } elseif ($experience != 'Yes' AND $experience != 'No') {
        $errorMsg[] = "It seems you have altered our experience buttons";
        $experienceERROR = true;
    }
    
    if($totalHousingChecked < 1){
        $errorMsg[] = "Please choose at least one residential status";
        $housingERROR = true;
    }
    
    if($shade == ""){
        $errorMsg[] = "Please select a shade option";
        $shadeERROR = true;
    } elseif (!verifyAlphaNum($shade)) {
        $errorMsg[] = "It seems you have altered our shade buttons";
        $shadeERROR = true;
    } elseif ($shade != 'Yes' AND $shade != 'No') {
        $errorMsg[] = "It seems you have altered our shade buttons";
        $shadeERROR = true;
    }
    
    if ($shadeType != ""){
        if (!verifyAlphaNum($shadeType)) {
            $errorMsg[] = "The type of shade you entered appears to have extra charactrs";
            $firstNameERROR = true;
        }
    }
    
    if($fenced == ""){
        $errorMsg[] = "Please select a fence option";
        $fencedERROR = true;
    } elseif (!verifyAlphaNum($fenced)) {
        $errorMsg[] = "It seems you have altered our fencing buttons";
        $fencedERROR = true;
    } elseif ($fenced != 'Yes' AND $fenced != 'No') {
        $errorMsg[] = "It seems you have altered our fencing buttons";
        $fencedERROR = true;
    }
    
    if($breed == ''){
        $errorMsg[] = "Please pick a breed";
        $breedERROR = true;
    } elseif ($breed != 'Dane' AND $breed != 'Pyrenees' AND $breed != 'Mastiff'
            AND $breed != 'Newfoundland' AND $breed != 'StBernard'
            AND $breed != 'Other'){
        $errorMsg[] = "It seems you have altered our breed values";
        $breedERROR = true;
    }
    
    if ($comments != ""){
        if (!verifyAlphaNum($comments)) {
            $errorMsg[] = "It appears your comments have extra characters";
            $commentsERROR = true;
        }
    }


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg is empty)
    //
    if(!$errorMsg){
        if($debug)
            print PHP_EOL . '<p>Form is valid</P>';
    

        
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    // SECTION: 2e Save Data
    //
    // This block saves the data to a CSV files

    $myFolder = 'data/';

    $myFileName = 'registration';

    $fileExt = '.csv';

    $filename = $myFolder . $myFileName . $fileExt;
    if ($debug) print PHP_EOL . '<p>filename is ' . $filename;

    // now we just open the file for append
    $file = fopen($filename, 'a');

    // write the forms informations
    fputcsv($file, $dataRecord);

    // close the files
    fclose($file);


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2f Create message
    //
    // build a message to display on the screen in section 3a and to mail
    // to the person filling out the form (section 2g).
    $message = '<h2>Your information.</h2>';
    
    foreach ($_POST as $htmlName => $value){
        
        $message .= '<p>';
        // breaks up the form names into words. for example
        // txtFirstName become First Name
        $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
        
        foreach ($camelCase as $oneWord){
            $message .= $oneWord . ' ';
        }
    
        $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        
    }
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2g Mail to user
    //
    // Process for mailing a message which contains the forms data
    // the message was built in section 2f.
    $to = $email; // the person who filled out the form
    $cc = '';
    $bcc = '';

    $from = 'Christopher Suitor <csuitor@uvm.edu>';

    // subject of mail should make sense to your form
    $subject = 'Dog Rescue: ';
    
    $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    
    
        } // end form is valid

}   //ends if form was submitted.


//##############################################################################
//
// SECTION 3 Display Form
//
?>

<article id="main">
    
    <?php
    //########################################################
    //
    // SECTION 3a/
    //
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if(isset($_POST["btnSubmit"]) AND empty($errorMsg)){ // closing of if marked with: end body submit
        print '<h2>Thank you for providing your information.</h2>';
        
        print '<p>For your records a copy of this data has ';
    
        if(!$mailed){
            print "not";
        }
        print 'been sent:</p>';
        print '<p>To: ' . $email . '</p>';
    
        print $message;
    }else{
    
        print '<h2>Adopt a Rescue!</h2>';
    
        //#############################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
    
        if($errorMsg){
            print '<div id="errors">' . PHP_EOL;
            print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
            print '<ol>' . PHP_EOL;
            
            foreach($errorMsg as $err){
                print '<li>' . $err . '</li>' . PHP_EOL;
            }
            
            print '</ol>' . PHP_EOL;
            print '</div>' . PHP_EOL;
        }
        
        //#############################################
        //
        // SECTION 3c html Form
        //
        /*Display the HTML form. note that the action is to this same page. $phpSelf
            * is defined in top.php
            * NOTE the line:
            * value="<?php print $email; ?>
            * this makes the form sticky by displaying either the initial default value (line??)
            * or the value they typed in (line ??)
            * NOTES this line:
            * <?php if($emailERROR) print 'class="mistake"'; ?>
            * this prints out a css class so that we can highlight the background etc. to
            * make it stand out that a mistake happened here.
         */
    ?>
    
    <form action="<?php print $phpSelf; ?>" 
          id="frmRegister" 
          method="post">
    
        <fieldset class="contact">
            <legend>Your Information</legend>
            <p>
                <label class="required text-field" for="txtFirstName">First Name: </label>
                <input autofocus
                       <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                       id="txtFirstName"
                       maxlength="45"
                       name="txtFirstName"
                       onfocus="this.select()"
                       placeholder="Enter your first name"
                       tabindex="100"
                       type="text"
                       value="<?php print $firstName; ?>"
                >
            </p>
            
            <p>
                <label class="required text-field" for="txtLastName">Last Name: </label>
                <input 
                       <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                       id="txtLastName"
                       maxlength="45"
                       name="txtLastName"
                       onfocus="this.select()"
                       placeholder="Enter your last name"
                       tabindex="120"
                       type="text"
                       value="<?php print $lastName; ?>"
                >
            </p>
            
            <p>
                <label class ="required text-field" for="txtEmail">Email: </label>
                    <input
                        <?php if ($emailERROR) print 'class="mistake"'; ?>
                        id="txtEmail"
                        maxlength="45"
                        name="txtEmail"
                        onfocus="this.select()"
                        placeholder="Enter a valid email address"
                        tabindex="140"
                        type="text"
                        value="<?php print $email; ?>"
                    >
            </p>
            
            <br/>
            
</fieldset><!-- ends Your Information -->
<br/>


<fieldset class="contact">
            <legend>Join the Cause</legend>
<!-- ##################### START RADIO BUTTONS ################### --> 
<p class="radio <?php if ($petsERROR) print ' mistake'; ?>">Do you already have pets?<br/>
    <label class="radio-field">
        <input type="radio"
               id="radPets1"
               name="radPets"
               value="Yes"
               tabindex="160"
               <?php if ($pets == 'Yes') echo ' checked="checked"'; ?>>
    Yes</label>
</p>

<p class="radio <?php if ($petsERROR) print ' mistake'; ?>">
    <label class="radio-field">
        <input type="radio"
               id="radPets2"
               name="radPets"
               value="No"
               tabindex="180"
               <?php if ($pets == "No") echo ' checked="checked"'; ?>>
    No</label>
</p>
<!-- ##################### END RADIO BUTTONS ################### --> 

<!-- ##################### START RADIO BUTTONS ################### --> 
<p class="radio <?php if ($experienceERROR) print ' mistake'; ?>">Do you have experience with rescue dogs?<br/>
    <label class="radio-field">
        <input type="radio"
               id="radExperience1"
               name="radExperience"
               value="Yes"
               tabindex="200"
               <?php if ($experience == 'Yes') echo ' checked="checked"'; ?>>
    Yes</label>
</p>

<p class="radio <?php if ($experienceERROR) print ' mistake'; ?>">
    <label class="radio-field">
        <input type="radio"
               id="radExperience2"
               name="radExperience"
               value="No"
               tabindex="220"
               <?php if ($experience == "No") echo ' checked="checked"'; ?>>
    No</label>
</p>
<!-- ##################### END RADIO BUTTONS ################### --> 

</fieldset> <!-- End Join the Cause -->
<br/>





<fieldset class="contact">
<legend>Residence Information</legend>
<!-- ##################### START CHECKBOXES ################### --> 
            <p class="checkbox <?php if ($housingERROR) print ' mistake'; ?>">
                <label class="check-field">
                    <input <?php if ($house) print " checked "; ?>
                        id="chkHouse"
                        name="chkHouse"
                        tabindex="240"
                        type="checkbox"
                        value="House"> House
                </label>

                <label class="check-field">
                    <input <?php if ($condo) print " checked "; ?>
                        id="chkCondo"
                        name="chkCondo"
                        tabindex="260"
                        type="checkbox"
                        value="Condo"> Condo
                </label>

                <label class="check-field">
                    <input <?php if ($apartment) print " checked "; ?>
                        id="chkApartment"
                        name="chkApartment"
                        tabindex="280"
                        type="checkbox"
                        value="Apartment"> Apartment
                </label>

                <label class="check-field">
                    <input <?php if ($owner) print " checked "; ?>
                        id="chkOwner"
                        name="chkOwner"
                        tabindex="300"
                        type="checkbox"
                        value="Owner"> Own Home?
                </label>

                <label class="check-field">
                    <input <?php if ($rent) print " checked "; ?>
                        id="chkRent"
                        name="chkRent"
                        tabindex="320"
                        type="checkbox"
                        value="Rent"> Rent?
                </label>
            </p>
            
<!-- ##################### END CHECKBOXES ################### -->

<!-- ##################### START RADIO BUTTONS ################### --> 
<p class="radio <?php if ($shadeERROR) print ' mistake'; ?>">Shade available?
    <label class="radio-field">
        <input type="radio"
               id="radShade1"
               name="radShade"
               value="Yes"
               tabindex="340"
               <?php if ($shade == 'Yes') echo ' checked="checked"'; ?>>
    Yes</label>

    <label class="radio-field">
        <input type="radio"
               id="radShade2"
               name="radShade"
               value="No"
               tabindex="360"
               <?php if ($shade == "No") echo ' checked="checked"'; ?>>
    No</label>

    
    <br/>
<!-- ##################### END RADIO BUTTONS ################### --> 

    <label class="text-field" for="txtShadeType">Type?</label>
        <input
               <?php if ($shadeTypeERROR) print 'class="mistake"'; ?>
               id="txtShadeType"
               maxlength="90"
               name="txtShadeType"
               onfocus="this.select()"
               placeholder="Shade in residence..."
               tabindex="380"
               type="text"
               value="<?php print $shadeType; ?>"
        >
    </p>
    <!-- ##################### START RADIO BUTTONS ################### --> 
    <p class="radio <?php if ($fencedERROR) print ' mistake'; ?>">Fenced yard?
        <label class="radio-field">
            <input type="radio"
                   id="radFenced1"
                   name="radFenced"
                   value="Yes"
                   tabindex="400"
                   <?php if ($fenced == 'Yes') echo ' checked="checked"'; ?>>
        Yes</label>

        <label class="radio-field">
            <input type="radio"
                   id="radFenced2"
                   name="radFenced"
                   value="No"
                   tabindex="420"
                   <?php if ($fenced == "No") echo ' checked="checked"'; ?>>
        No</label>
    </p>
<!-- ##################### END RADIO BUTTONS ################### --> 
</fieldset> <!-- end Residence Information -->

<br/>

<fieldset>
    <legend>Rescue</legend>
<!-- ##################### START LISTBOX ################### --> 
            <p>
                Breed:
            </p>
            
            <p class="listbox <?php if ($breedERROR) print ' mistake'; ?>">
                <select id="lstBreed" size="4"
                        name="lstBreed"
                        tabindex="440">
                    <option <?php if($breed == "Dane") print " selected "; ?>
                        value="Dane">Dane</option>
                    
                    <option <?php if($breed == "Pyrenees") print " selected "; ?>
                        value="Pyrenees">Pyrenees</option>
                    
                    <option <?php if($breed == "Mastiff") print " selected "; ?>
                        value="Mastiff">Mastiff</option>
                    
                    <option <?php if($breed == "Newfoundland") print " selected "; ?>
                        value="Newfoundland">Newfoundland</option>
                    
                    <option <?php if($breed == "StBernard") print " selected "; ?>
                        value="StBernard">St. Bernard</option>
                </select>
            </p>
            
<!-- ##################### END LISTBOX ################### --> 
<br/>
<!-- ##################### START TEXTAREA ################### -->
            <p class ="textarea">
                <label for="txtComments">Additional Comments:</label><br/>
                <textarea <?php if ($commentsERROR) print 'class="mistake"'; ?>
                    id="txtComments"
                    name="txtComments"
                    onfocus="this.select()"
                    placeholder="Enter your comments..."
                    tabindex="460"><?php print $comments; ?></textarea>
            </p>
<!-- ##################### END TEXTAREA ################### --> 
</fieldset>

<br/>

<fieldset class="buttons">
    <legend>Submit</legend>
        <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Register">
</fieldset><!-- ends buttons -->  
<br/>
    </form>
    
    <?php
        } //end body submit
    ?>
    
</article>

<?php include 'footer.php'; ?>

</body>
</html>