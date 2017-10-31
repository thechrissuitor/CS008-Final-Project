<!-- ######################    Start nav   ########################## -->
<nav>
    <ol>
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">Home</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "form") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">Form</a>';
        print '</li>';
        
        print '<li class="';
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
