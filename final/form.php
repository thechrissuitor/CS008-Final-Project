<?php
include 'top.php';
//%^^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variable
//
// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){ // later you can uncomment the if statement
print '<p>Post Array:</p><pre>';
print_r($_POST);
print '</pre>';
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

$email = "csuitor@uvm.edu";

$breed = "None";

$interest = "Interested";

$styleApprov = false; //not checked

$infoApprov = false; //not checked

$layoutApprov = false; //not checked

$styleDisapprov = false; //not checked

$infoDisapprov = false; //not checked

$layoutDisapprov = false; //not checked

$social = "";

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

$breedERROR = false;

$interestERROR = false;

$approvalERROR = false;
$totalApprovalChecked = 0;

$disapprovalERROR = false;
$totalDisapprovalChecked = 0;

$socialERROR = false;

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
    
    $breed = htmlentities($_POST["lstBreed"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $breed;
    
    $interest = filter_var($_POST["radInterest"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $interest;
    
    if(isset($_POST["chkStyleApprov"])) {
        $styleApprov = true;
        $totalApprovalChecked++;
    } else {
        $styleApprov = false;
    }
    $dataRecord[] = $styleApprov;
    
    if(isset($_POST["chkInfoApprov"])) {
        $infoApprov = true;
        $totalApprovalChecked++;
    } else {
        $infoApprov = false;
    }
    $dataRecord[] = $infoApprov;
    
    if(isset($_POST["chkLayoutApprov"])) {
        $layoutApprov = true;
        $totalApprovalChecked++;
    } else {
        $layoutApprov = false;
    }
    $dataRecord[] = $layoutApprov;
    
    if(isset($_POST["chkStyleDisapprov"])) {
        $styleDisapprov = true;
        $totalDisapprovalChecked++;
    } else {
        $styleDisapprov = false;
    }
    $dataRecord[] = $styleDisapprov;
    
    if(isset($_POST["chkInfoDisapprov"])) {
        $infoDisapprov = true;
        $totalDisapprovalChecked++;
    } else {
        $infoDisapprov = false;
    }
    $dataRecord[] = $infoDisapprov;
    
    if(isset($_POST["chkLayoutDisapprov"])) {
        $layoutDisapprov = true;
        $totalDisapprovalChecked++;
    } else {
        $layoutDisapprov = false;
    }
    $dataRecord[] = $layoutDisapprov;
    
    if($social!=""){
        $social = filter_var($_POST["radSocial"], FILTER_SANITIZE_EMAIL);
        $dataRecord[] = $social;
    }
    
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
        $errorMsg[] = "Your first name appears to have extra charactrs.";
        $firstNameERROR = true;
    }
    
    if($lastName == ""){
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra characters.";
        $lastNameERROR = true;
    }

    if($email == ""){
        $errorMsg[] ='Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = 'Your email address appears to be incorreect.';
        $emailERROR = true;
    }
    
    if($breed == ''){
        $errorMsg[] = "Please pick a value";
        $breedERROR = true;
    } elseif ($breed != 'None' AND $breed != 'Corgi' AND $breed != 'Chihuahua'
            AND $breed != 'Dalmation' AND $breed != 'Doberman'
            AND $breed != 'Great_Dane' AND $breed != 'Mastiff'
            AND $breed != 'Pug' AND $breed != 'Retriever'
            AND $breed != 'Other'){
        $errorMsg[] = "Please pick a value";
        $breedERROR = true;
    }
    
    if($interest == ""){
        $errorMsg[] = "Please select your opinion.";
        $interestERROR = true;
    } elseif (!verifyAlphaNum($interest)) {
        $errorMsg[] = "It seems you have altered our buttons.";
        $interestERROR = true;
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
    
        print '<h2> Register Today</h2>';
        print '<p class="form-heading">Your information will greatly help us with our research.</p>';
    
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
            <legend>Get Connected</legend>
            <p>
                <label class="required text-field" for="txtFirstName">First Name</label>
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
                <label class="required text-field" for="txtLastName">Last Name</label>
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
                <label class ="required text-field" for="txtEmail">Email</label>
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
<!-- ##################### START LISTBOX ################### --> 
            <p>
                What kind of dog do you have?
            </p>
            
            <p class="listbox <?php if ($breedERROR) print ' mistake'; ?>">
                <select id="lstBreed" size="4"
                        name="lstBreed"
                        tabindex="160">
                    <option <?php if($breed == "None") print " selected "; ?>
                        value="None">None</option>
                    
                    <option <?php if($breed == "Corgi") print " selected "; ?>
                        value="Corgi">Corgi</option>
                    
                    <option <?php if($breed == "Chihuahua") print " selected "; ?>
                        value="Chihuahua">Chihuahua</option>
                    
                    <option <?php if($breed == "Dalmation") print " selected "; ?>
                        value="Dalmation">Dalmation</option>
                    
                    <option <?php if($breed == "Doberman") print " selected "; ?>
                        value="Doberman">Doberman</option>
                    
                    <option <?php if($breed == "Great_Dane") print " selected "; ?>
                        value="Great_Dane">Great Dane</option>
                    
                    <option <?php if($breed == "Mastiff") print " selected "; ?>
                        value="Mastiff">Mastiff</option>
                    
                    <option <?php if($breed == "Pug") print " selected "; ?>
                        value="Pug">Pug</option>
                    
                    <option <?php if($breed == "Retriever") print " selected "; ?>
                        value="Retriever">Retriever</option>
                </select>
            </p>
            
<!-- ##################### END LISTBOX ################### --> 
<br/>
<!-- ##################### START RADIO BUTTONS ################### --> 
            <p class="radio <?php if ($interestERROR) print ' mistake'; ?>">Your opinion on dog rescue:<br/>
                <label class="radio-field">
                    <input type="radio"
                           id="radInterest1"
                           name="radInterest"
                           value="Interested"
                           tabindex="180"
                           <?php if ($interest == 'Interested') echo ' checked="checked"'; ?>>
                Interested</label>
            </p>
            
            <p class="radio <?php if ($interestERROR) print ' mistake'; ?>">
                <label class="radio-field">
                    <input type="radio"
                           id="radInterest2"
                           name="radInterest"
                           value="Slightly_Interested"
                           tabindex="200"
                           <?php if ($interest == "Slightly_Interested") echo ' checked="checked"'; ?>>
                Slightly Interested</label>
            </p>
            
            <p class="radio <?php if ($interestERROR) print ' mistake'; ?>">
                <label class="radio-field">
                    <input type="radio"
                           id="radInterest3"
                           name="radInterest"
                           value="Not_Interested"
                           tabindex="220"
                           <?php if ($interest == "Not_Interested") echo ' checked="checked"'; ?>>
                Not Interested</label>
            </p>
<!-- ##################### END RADIO BUTTONS ################### --> 
        </fieldset><!-- ends contact -->
        
        
        
        <fieldset>
            <legend>Optional</legend>
<!-- ##################### START CHECKBOXES ################### --> 
            <p class="checkbox <?php if ($approvalERROR) print ' mistake'; ?>">
                What did you like about our website?<br/>
                <label class="check-field">
                    <input <?php if ($styleApprov) print " checked "; ?>
                        id="chkStyleApprov"
                        name="chkStyleApprov"
                        tabindex="240"
                        type="checkbox"
                        value="Style"> Style
                </label>
            </p>
            
            <p class="checkbox <?php if ($approvalERROR) print ' mistake'; ?>">
                <label class="check-field">
                    <input <?php if ($infoApprov) print " checked "; ?>
                        id="chkInfoApprov"
                        name="chkInfoApprov"
                        tabindex="260"
                        type="checkbox"
                        value="Information"> Information
                </label>
            </p>
            
            <p class="checkbox <?php if ($approvalERROR) print ' mistake'; ?>">
                <label class="check-field">
                    <input <?php if ($layoutApprov) print " checked "; ?>
                        id="chkLayoutApprov"
                        name="chkLayoutApprov"
                        tabindex="280"
                        type="checkbox"
                        value="Layout"> Layout
                </label>
            </p>
            
<!-- ##################### END CHECKBOXES ################### -->
<br/>
<!-- ##################### START CHECKBOXES ################### --> 
            <p class="checkbox <?php if ($dispprovalERROR) print ' mistake'; ?>">
                What could we improve?<br/>
                <label class="check-field">
                    <input <?php if ($styleDisapprov) print " checked "; ?>
                        id="chkStyleDisapprov"
                        name="chkStyleDisapprov"
                        tabindex="300"
                        type="checkbox"
                        value="Style"> Style
                </label>
            </p>
            
            <p class="checkbox <?php if ($disapprovalERROR) print ' mistake'; ?>">
                <label class="check-field">
                    <input <?php if ($infoDisapprov) print " checked "; ?>
                        id="chkInfoDisapprov"
                        name="chkInfoDisapprov"
                        tabindex="320"
                        type="checkbox"
                        value="Information"> Information
                </label>
            </p>
            
            <p class="checkbox <?php if ($disapprovalERROR) print ' mistake'; ?>">
                <label class="check-field">
                    <input <?php if ($layoutDisapprov) print " checked "; ?>
                        id="chkLayoutDisapprov"
                        name="chkLayoutDisapprov"
                        tabindex="340"
                        type="checkbox"
                        value="Layout"> Layout
                </label>
            </p>
            
<!-- ##################### END CHECKBOXES ################### -->
<br/>
<!-- ##################### START RADIO BUTTONS ################### --> 
            <p class="radio <?php if ($socialERROR) print ' mistake'; ?>">Did you add us on Linkedln and Facebook?<br/>
                <label class="radio-field">
                    <input type="radio"
                           id="radSocial"
                           name="radSocial"
                           value="Yes"
                           tabindex="360"
                           <?php if ($social == 'Yes') echo ' checked="checked"'; ?>>
                Yes</label>
            </p>
            
            <p class="radio <?php if ($socialERROR) print ' mistake'; ?>">
                <label class="radio-field">
                    <input type="radio"
                           id="radSocial"
                           name="radSocial"
                           value="No"
                           tabindex="380"
                           <?php if ($interest == "No") echo ' checked="checked"'; ?>>
                No</label>
            </p>
<!-- ##################### END RADIO BUTTONS ################### --> 
<br/>
<!-- ##################### START TEXTAREA ################### -->
            <p class ="textarea">
                <label for="txtComments">Additional Comments:</label><br/>
                <textarea <?php if ($commentsERROR) print 'class="mistake"'; ?>
                    id="txtComments"
                    name="txtComments"
                    onfocus="this.select()"
                    placeholder="Enter your comments..."
                    tabindex="400"><?php print $comments; ?></textarea>
            </p>
<!-- ##################### END TEXTAREA ################### --> 


<br/>

        </fieldset>
        
        <fieldset class="buttons">
            <legend></legend>
            <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Register">
        </fieldset><!-- ends buttons -->       
    </form>
    
    <?php
        } //end body submit
    ?>
    
</article>

<?php include 'footer.php'; ?>

</body>
</html>