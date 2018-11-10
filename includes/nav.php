<ul>
    <?php
        foreach ($navItems as $item){
            echo "<li><a href=\"$item[slug]\"> $item[title] </a></li>";
        }
        
        if (isset($_SESSION['userId']))
        {
            foreach ($navItems_signedin as $item){
            echo "<li><a href=\"$item[slug]\"> $item[title] </a></li>";
        }
        }                
    ?>
</ul>