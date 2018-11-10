<?php
    define('TITLE',"Menu | Franklin's Fine Dining");
    include 'includes/header.php';
    
    function suggestedTip($price, $tip){
        $totalTip = $price * $tip;
        echo $totalTip;
    }
    
    if (isset($_GET['item'])){
        $menuItem = strip_bad_chars($_GET['item']);
        
        $dish = $menuItems[$menuItem];
    }
?>

<hr>

<div id="dish" >
    <h1><?php echo $dish[title]; ?> <span class="price"><sup>$</sup><?php echo $dish[price]; ?></span></h1>
    <p><?php echo $dish[blurb]; ?></p>
    <br>
    <p><strong>Suggested Beverage: <?php echo $dish[drink]; ?></strong></p>
    <p><em>Suggested tip: <sup>$</sup><?php suggestedTip($dish[price], 0.20); ?></em></p>
</div>

<hr>

<a href="menu.php" class="button previous">&laquo; Back to Menu</a>



<?php include 'includes/footer.php'; ?>
