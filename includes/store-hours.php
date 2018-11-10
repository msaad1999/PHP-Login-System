<?php 

    // REQUIRED
    // Set your default time zone (listed here: http://php.net/manual/en/timezones.php)
    date_default_timezone_set('Asia/Karachi');
    // Include the store hours class
    // require __DIR__ . 'includes/StoreHours.class.php';
    include 'includes/StoreHours.class.php';
    
    // REQUIRED
    // Define daily open hours
    // Must be in 24-hour format, separated by dash
    // If closed for the day, leave blank (ex. sunday)
    // If open multiple times in one day, enter time ranges separated by a comma
    $hours = array(
        'mon' => array('00:00-00:00'),
        'tue' => array('13:00-21:00'),
        'wed' => array('13:00-21:00'),
        'thu' => array('13:00-21:00'), // Open late
        'fri' => array('16:00-23:00'),
        'sat' => array('16:00-23:00'),
        'sun' => array('00:00-00:00')
    );

    // OPTIONAL
    // Add exceptions (great for holidays etc.)
    // MUST be in a format month/day[/year] or [year-]month-day
    // Do not include the year if the exception repeats annually
    $exceptions = array(
        // '2/24'  => array('11:00-18:00'),
        // '10/18' => array('11:00-16:00', '18:00-20:30')
    );

    $config = array(
        'separator'      => ' - ',
        'join'           => ' and ',
        'format'         => 'g:ia',
        'overview_weekdays'  => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')
    );

    // Instantiate class
    $store_hours = new StoreHours($hours, $exceptions, $config);
    
    // Display open / closed message
    
    if($store_hours->is_open()) {
        echo "<strong class='open'>"
        . "Yes, we're open! Today's hours are " . $store_hours->hours_today() . ".</strong>";
    } else {
        echo "<strong class='closed'>"
        . "Sorry, we're closed. Today's hours are " . $store_hours->hours_today() . ".</strong>";
    }

    /*
    // Display full list of open hours (for a week without exceptions)
    echo '<table>';
    foreach ($store_hours->hours_this_week() as $days => $hours) {
        echo '<tr>';
        echo '<td>' . $days . '</td>';
        echo '<td>' . $hours . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    // Same list, but group days with identical hours
    echo '<table>';
    foreach ($store_hours->hours_this_week(true) as $days => $hours) {
        echo '<tr>';
        echo '<td>' . $days . '</td>';
        echo '<td>' . $hours . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    */
    
    ?>
    
