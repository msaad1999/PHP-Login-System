<?php 

    // DB Connect, SELECT, INSERT

    require __DIR__ . '/../setup/db.php';

    function connect() {

        $C = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($C->connect_error) {

            return false;

        } else {

            return $C;

        }

    }

    function sqlSelect($connection, $query, $format = false, ...$vars) {
        $stmt = $connection->prepare($query);
        if($format) {
            $stmt->bind_param($format, ...$vars);            
        }
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        $stmt->close();
        return false;
    }

    function sqlInsert($C, $query, $format = false, ...$vars) {
        $stmt = $C->prepare($query);
        if($format) {
            $stmt->bind_param($format, ...$vars);            
        }
        if($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        }
        $stmt->close();
        return -1;
    }

    function sqlUpdate($C, $query, $format = false, ...$vars) {
		$stmt = $C->prepare($query);
		if($format) {
			$stmt->bind_param($format, ...$vars);
		}
		if($stmt->execute()) {
			$stmt->close();
			return true;
		}
		$stmt->close();
		return false;
	}

    function sqlDelete($C, $query, $format = false, ...$vars) {
        $stmt = $C->prepare($query);
        if($format) {
            $stmt->bind_param($format, ...$vars);            
        }
        if($stmt->execute()) {
            $ar = $stmt->affected_rows;
            $stmt->close();
            return $ar;
        }
        $stmt->close();
        return -1;
    }

    function recordLastUserLogin($C, $email) {

        $u = "UPDATE users SET last_login_at = NOW() WHERE email=?";
        $d = "DELETE FROM user_login_attempts WHERE email=?";

        $C->autocommit(FALSE);

        $su = $C->prepare($u);
        $su->bind_param("s", $email);

        if ($su->execute()) { // update user

            $sd = $C->prepare($d);
            $sd->bind_param("s", $email);

            if ($sd->execute()) { // delete attempt

                $C->autocommit(TRUE); // All good, commit!
                $sd->close();
                $su->close();
                return true;

            } else {

                $C->rollback();
                $sd->close();
                $su->close();
                $C->autocommit(TRUE);
                return false;

            }
        
        } else {

            $C->rollback();
            $su->close();
            $C->autocommit(TRUE);
            return false;

        }

        $C->rollback();
        $su->close();
        $C->autocommit(TRUE);
		return false;

    }

    function recordUserWasVerified($C, $email) {

        $u = "UPDATE users SET verified_at = NOW() WHERE email=?";
        $d = "DELETE FROM user_tokens WHERE email=? AND auth_type IN ('signup','verify')";

        $C->autocommit(FALSE);

        $su = $C->prepare($u);
        $su->bind_param("s", $email);

        if ($su->execute()) { // update user

            $sd = $C->prepare($d);
            $sd->bind_param("s", $email);

            if ($sd->execute()) { // delete token

                $C->autocommit(TRUE); // All good, commit!
                $sd->close();
                $su->close();
                return true;

            } else {

                $C->rollback();
                $sd->close();
                $su->close();
                $C->autocommit(TRUE);
                return false;

            }
        
        } else {

            $C->rollback();
            $su->close();
            $C->autocommit(TRUE);
            return false;

        }

        $C->rollback();
        $su->close();
        $C->autocommit(TRUE);
		return false;

    }

    function recordUserNewPassword($C, $email, $pwd) {

        $u = "UPDATE users SET pwd=? WHERE email=?";
        $d = "DELETE FROM user_tokens WHERE email=? AND auth_type='reset'";

        $C->autocommit(FALSE);

        $su = $C->prepare($u);
        $su->bind_param("ss", $pwd, $email);

        if ($su->execute()) { // update user

            $sd = $C->prepare($d);
            $sd->bind_param("s", $email);

            if ($sd->execute()) { // delete token

                $C->autocommit(TRUE); // All good, commit!
                $sd->close();
                $su->close();
                return true;

            } else {

                $C->rollback();
                $sd->close();
                $su->close();
                $C->autocommit(TRUE);
                return false;

            }
        
        } else {

            $C->rollback();
            $su->close();
            $C->autocommit(TRUE);
            return false;

        }

        $C->rollback();
        $su->close();
        $C->autocommit(TRUE);
		return false;

    }

    function recordLoginAttempt($C, $email, $ip, $attempt_time) {
        
        $la = 'INSERT INTO user_login_attempts (email, ip, attempt_time) VALUES (?, ?, ?)';

        $stmt = $C->prepare($la);
        $stmt->bind_param("sss", $email, $ip, $attempt_time);

        if($stmt->execute()) {

            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;

    }    

?>