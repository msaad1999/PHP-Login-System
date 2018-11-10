<?php

    // nav items   
    $navItems = array(
                        array(
                            slug => "index.php",
                            title => "Home"
                        ),
                        array(
                            slug => "team.php",
                            title => "Our Team"
                        ),
                        array(
                            slug => "menu.php",
                            title => "Our Menu"
                        ),
                        array(
                            slug => "contact.php",
                            title => "Contact Us"
                        ),
                    );
    
    $navItems_signedin = array(
                        array(
                            slug => "edit-profile.php",
                            title => "Edit Profile"
                        ),
                    );
    
    // Team Members
    $teamMembers = array(
                            array(
                                name => "John Smith",
                                position => "Owner",
                                bio => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do "
                                . "eiusmod tempor incididunt ut labore et dolore magna aliqua",
                                img => 'john'
                            ),      
                            array(
                                name => "Francis",
                                position => "General Manager",
                                bio => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do "
                                . "eiusmod tempor incididunt ut labore et dolore magna aliqua",
                                img => 'francis'
                            ),
                            array(
                                name => "Carlos",
                                position => "Head Chef",
                                bio => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do "
                                . "eiusmod tempor incididunt ut labore et dolore magna aliqua",
                                img => 'carlos'
                            ),
                        );
    
    // Menu items
    $menuItems = array(
                        
                        'club-sandwich' => array(
                            title => "Club Sandwich",
                            price => 11,
                            blurb => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                            drink => "Club Soda"
                        ),
        
                        'dill-salmon' => array(
                            title => "Lemon &amp; Dill Salmon",
                            price => 18,
                            blurb => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                            drink => "Fancy Wine"
                        ),
        
                            'super-salad' => array(
                            title => "The Super Salad<sup>&reg;</sup>",
                            price => 34,
                            blurb => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                            drink => "Jug O' Water"
                        ),
        
                        'mexican-barbacoa' => array(
                            title => "Mexican Barbacoa",
                            price => 23,
                            blurb => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                            drink => "Beer with a Lime"
                        ),
        
                    );
    
    
?>