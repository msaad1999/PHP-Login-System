<?php 
	require_once 'php/utils.php'; 
?>

<!DOCTYPE html>
<html lang="en">

    <head>
	    
        <meta charset="UTF-8">
	    <meta name="csrf_token" content="<?php echo createToken(); ?>" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Email Verification - Secure Site</title>
	    <link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']) . '/style.css' ?>" />

    </head>

    <body>
	
        <?php
		
            if(isset($_GET['id']) && $_GET['id'] !== '' && isset($_GET['hash']) && $_GET['hash'] !== '') {
			
                echo '<div class="message">';
			
                $C = connect();
			
                if($C) {
				
                    $res = sqlSelect($C, 'SELECT user,hash,timestamp FROM requests WHERE id=? AND type=0', 'i', $_GET['id']);
				
                    if($res && $res->num_rows === 1) {
					
                        $request = $res->fetch_assoc();
					
                        if($request['timestamp'] > time() - 60*60*24) {
						
                            if(password_verify(urlSafeDecode($_GET['hash']), $request['hash'])) {
							
                                if(sqlUpdate($C, 'UPDATE users SET verified=1 WHERE id=?', 'i', $request['user'])) {
								
                                    sqlUpdate($C, 'DELETE FROM requests WHERE user=? AND type=0', 'i', $request['user']);
								
                                    echo '<h2>Email Verified</h2>';
							
                                } else {
								
                                    echo '<h2>Failed to Update Database</h2>';
							
                                }
						
                            } else {
							
                                echo '<h2>Invalid Verification Request</h2>';
						
                            }
					
                        } else {
						
                            echo '<h2>Verification Request Expired</h2><a href="./validate">Click here to send another one</a>';
					
                        }
					
                        $res->free_result();
				
                    } else {
					
                        echo '<h2>Invalid Verification Request</h2>';
				
                    }
				
                    $C->close();
			
                } else {
				
                    echo '<h2>Failed to Connect to Database</h2>';
			
                }
			
                echo '</div>';
		
            } else {
			
?>

        <div class="formWrapper">

				<form id="validateEmailForm">

					<h1>Email Verification Request</h1>
					
                    <div id="errs" class="errorcontainer"></div>
					
                    <div class="inputblock">
						<label for="validateEmail">Email</label>
						<input id="validateEmail" name="validateEmail" type="email" autocomplete="email" required placeholder="Enter your email" onkeydown="if(event.key === 'Enter'){event.preventDefault();sendValidateEmailRequest();}"/>
					</div>
					
                    <br>
					
                    <div class="btn" onclick="sendValidateEmailRequest();">Send Verification Request</div>
					
                    <br>
					<br>
					<br>
					<a href="./login">Already Verified? Log In</a>
				
                </form>

				<svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 32 1440 320"><defs><linearGradient id="a" x1="50%" x2="50%" y1="-10.959%" y2="100%"><stop stop-color="#ffffff" stop-opacity=".10" offset="0%"/><stop stop-color="#FFFFFF" stop-opacity=".05" offset="100%"/></linearGradient></defs><path fill="url(#a)" fill-opacity="1" d="M 0 320 L 48 288 C 96 256 192 192 288 160 C 384 128 480 128 576 112 C 672 96 768 64 864 48 C 960 32 1056 32 1152 32 C 1248 32 1344 32 1392 32 L 1440 32 L 1440 2000 L 1392 2000 C 1344 2000 1248 2000 1152 2000 C 1056 2000 960 2000 864 2000 C 768 2000 672 2000 576 2000 C 480 2000 384 2000 288 2000 C 192 2000 96 2000 48 2000 L 0 2000 Z"></path></svg>
				<svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 32 1440 320"><defs><linearGradient id="a" x1="50%" x2="50%" y1="-10.959%" y2="100%"><stop stop-color="#ffffff" stop-opacity=".10" offset="0%"/><stop stop-color="#FFFFFF" stop-opacity=".05" offset="100%"/></linearGradient></defs><path fill="url(#a)" fill-opacity="1" d="M 0 320 L 48 288 C 96 256 192 192 288 160 C 384 128 480 128 576 112 C 672 96 768 64 864 48 C 960 32 1056 32 1152 32 C 1248 32 1344 32 1392 32 L 1440 32 L 1440 2000 L 1392 2000 C 1344 2000 1248 2000 1152 2000 C 1056 2000 960 2000 864 2000 C 768 2000 672 2000 576 2000 C 480 2000 384 2000 288 2000 C 192 2000 96 2000 48 2000 L 0 2000 Z"></path></svg>
			
        </div>

<?php
		    }
?>

	    <script src="<?php echo dirname($_SERVER['PHP_SELF']) . '/script.js' ?>"></script>
    
    </body>

</html>