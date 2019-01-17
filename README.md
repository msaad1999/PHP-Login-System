<p align="center">
  <img src="_git%20assets/cover.png" width="800" align="center"/>
</p>

> A complete PHP Login and Registration System with Profile editing & authentication System

# Table of Contents

* [Installation](#installation)
  * [Requirements](#requirements)
  * [Installation Steps](#installation-steps)
  * [Getting Started](#getting-started)
* [Features](#Features)
* [Components](#Components)
  * [Languages](#Languages)
  * [Development Environment](#Development-Environment)
  * [Database](#database)
  * [DBMS](#DBMS)
  * [API](#api)
  * [Frameworks and Libraries](#Frameworks-and-Libraries)
  * [External PLugins](#external-plugins)
* [Details](#details)
* [View KLiK, The Complete Project](#klik-social-media-website)



## Installation

#### Requirements
* PHP
* Apache server
* MySQL Database
* SQL

> All of these requirements can be completed at once by simply installing a server stack like `Wamp` or `Xampp`

#### Installation Steps
1. Import the `DBcreation.sql` file in the `includes` folder into phpMyAdmin. There is no need for any change in the .sql file. This will create the database required for the application to function.

2. Edit the `dbh.inc.php` file in the `includes` folder to create the database connection. Change the password and username to the ones being used within `phpMyAdmin`. There is no need to change anything else.

```php
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "examplePassword";
$dBName = "loginsystem";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3307);

if (!$conn)
{
    die("Connection failed: ". mysqli_connect_error());
}
```
> The port number does not need to be changed under normal circumstances, but if you are running into a problem or the server stack is installed on another port, feel free to change it, but do so carefully.

3. Edit the `email-server.php` file in the `includes` folder and change the variables accordingly:

  * `$SMTPuser` : email address on `gmail`
  * `$SMTPpwd`  : email address password
  * `SMTPtitle` : hypothetical company's name

```php
$SMTPuser = 'klik.official.website@gmail.com';   
$SMTPpwd = 'some-example-password';
$SMTPtitle = "KLiK inc.";
```
> This step is mainly for setting up an email account to enable the `contact` and `password reset system`, all of which require mailing.

#### Getting started
The database already contains two pre-made accounts for you to explore around with. If not sufficient, head over to the `signup page` and start making new accounts.
##### Existing Accounts:
```
username: admin
password: admin
```
```
username: user
password: user
```

> **Note:** The GUI files are in the `root directory`, and the `backend files` are present in the `includes` folder. The main HTML structuring files are the `HTML-head.php` and `HTML-footer.php`, which also reside in the includes folder

## Features

* [Registration / Signup System](#registration-signup-system)
* [Login System](#login-system)
* [Profile System](#profile-system)
* [Profile Editing System](#profile-editing-system)
* [Contact System](#contact-system)


## Components

#### Languages
```
PHP 5.6.40
SQL 14.0
HTML5
CSS3
```

#### Development Environment
```
WampServer Stack 3.0.6
Windows 10
```

#### Database
```
MySQL Database 8.0.13
```

#### DBMS
```
phpMyAdmin 4.8.3
```

#### API
```
MySQLi APIs
```

#### Frameworks and Libraries
```
BootStrap v4.2.1
```

#### External Plugins
```
[PHPMailer 6.0.6](https://github.com/PHPMailer/PHPMailer)
```
> This was used for creating a `mail server` on `Windows localhost`, since there is not one like in Linux. This plugin was used for the sending and receiving of emails on localhost, this is not needed on a live domain

## Details

> Details of important Features of the Application

### Registration / Signup System

* A `status icon` in the top left corner shows online or logged out status
* registration is done through the `signup` page.
* `username` cannot be changed after signing up, since i thought it would be an exploitable weakness
* `email` required for registration.
* Password needs to be re-entered for additional confirmation
* Passwords `encrypted` before being stored in database so even owners donot have access to them
* User can set a `profile image` at signup. In case they dont, their profile image is set to a default image.

> currently the upload image button does not give a visible response on clicking and uploading an image, but it does work. It is purely a design matter and not a back-end issue

* There are also additional information fields that are `optional`, i.e; a user can signup without setting them.
* Optional fields are `gender`, `full name`, `profile headline` and `bio`
* Implemented several `authentication methods` to verify user info before registering him.
* Authentication checks for:
  * `empty fields`
  * `invalid username or email`
  * `password mismatch`
  * `wrong profile image error`
  * `SQL errors`
  * `internal server errors`

### Login System

* `username` and `password` required for logging in.
* Authentication checks to return valid error messages.
* Authentication checks for:
  * `wrong username`
  * `wrong password`

### Profile System

* Each is assigned a `user profile` on registration.
* Profile can be accessed through the `menu options` which become visible after logging in or the `link` beneath the profile image on the right.
* Profile page displays all of the User's information, except (naturally) for the password.
* Displayed information:
  * `profile image`
  * `username`
  * `full name`
  * `gender`
  * `headline`
  * `bio`
* Profile page cannot be accessed without logging in.
* Signup page cannot be page `after logging in`.

### Profile Editing System

* User can edit his profile information with the help of the `profile editing system`
* Profile Editing page can be accessed from `menu option` or `link` below profile image on the right
* `username` cannot be changed
* Profile Editing already has the existing information so user does not have to type everything all over again if he merely wishes to slightly edit current information.
* Current password required for changing password.
* Changing password also requires confirmation / re-entering of new password.
* user profile image can also be changed.
* Authentication checks for:
  * `empty fields`
  * `invalid information`
  * `wrong current password`
  * `new password mismatch`
  * `image upload errors`

### Contact System

* contact system is accessible with or without logging in
* uses `PHPMailer` to create an email server with which it sends emails.
* options for subscribing to newsletter (or basically any additional option for contacting)
* does not require PHPMailer on live domain (only required on windows localhost)

### Security

* `Password hashing` before storing in database.
* Filtering of information obtained from `$_GET` and `$_POST` methods to prevent `header injection`.
* Implementation of `MySQLi Prepared Statements` for **advanced** database security.

  **Example:**
```php
$sql = "select uidUsers from users where uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
       }
```

### KLiK - Social Media Website

Check out the complete project for this login system. [KLiK](https://github.com/msaad1999/KLiK-SocialMediaWebsite) is a complete Social Media website, along with a Complete Login/Registration system, Profile system, Chat room, Forum system and Blog/Polls/Event Management System.

> Check out [KLiK here](https://github.com/msaad1999/KLiK-SocialMediaWebsite)

<p align="center">
  <img src="_git%20assets/klik.png" width="500" align="center"/>
</p>

> Do star my projects! :)

> If you liked my work, please show support by `starring` the repository! It means a lot to me, and is all im asking for.
