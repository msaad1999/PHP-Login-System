<?php
    define('TITLE',"Team | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id='team-members' class='cf'>
    
    <h1>Our Team At Franklins</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
        esse cillum dolore eu fugiat nulla pariatur. </p>
    <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit</strong>
    
    <hr> 
    
    <?php 
        foreach($teamMembers as $member){
    ?>
    
    <div class='member'>
        <img src="img/<?php echo $member[img];?>.png" alt="<?php echo $member[name]; ?>">
        <h2><?php echo $member[name]; ?></h2>
        <p><?php echo $member[bio]; ?></p>
    </div>
    
    <?php
        }
    ?>
    
</div>

<hr>

<?php include 'includes/footer.php'; ?>
