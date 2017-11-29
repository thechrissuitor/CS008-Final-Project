<!-- ######################    Start nav   ########################## -->
<nav>
    <ol>
        <?php
        print '<li class="links';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">Home</a>';
        print '</li>';
        
        print '<li class="links';
        if ($path_parts['filename'] == "photos") {
            print ' activePage ';
        }
        print '">';
        print '<a href="photos.php">Photos</a>';
        print '</li>';
        
        print '<li class="links';
        if ($path_parts['filename'] == "drhc") {
            print ' activePage ';
        }
        print '">';
        print '<a href="drhc.php">Rehab & Home Coming</a>';
        print '</li>';
        
        print '<li class="links';
        if ($path_parts['filename'] == "form") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">Form</a>';
        print '</li>';
        
        print '<li class="links';
        if ($path_parts['filename'] == "abuse") {
            print ' activePage ';
        }
        print '">';
        print '<a href="abuse.php">Abuse</a>';
        print '</li>';
        
        print '<li class="links';
        if ($path_parts['filename'] == "aboutus") {
            print ' activePage ';
        }
        print '">';
        print '<a href="aboutus.php">About Us</a>';
        print '</li>';
        ?>
    </ol>
</nav>
<!-- ######################    End nav   ########################## -->