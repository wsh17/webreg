<!----------------------
// Author: B Harper
// Code to make web registration form in html/PHP and use external source sendgrid to email confirmations
// Cloud Foundry Demo 
// ---------------------->
<!DOCTYPE HTML>  
<html>
<head>
<img src="./cisco-metacloud-700x325.jpg" width="150" height="65" title="Logo" alt="Metacloud" />
<img src="./WP-Pivotal-Cloud-Foundry-620x410.png" width="150" height="65" title="Logo" alt="Pivotal" />

</head>
<body>  

<?php
// define variables and set to empty values
$name = $fname = $lname = $email = $cloud = $comment = $website = $econfirm = $company ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $company = test_input($_POST["company"]);
  $title = test_input($_POST["title"]);
  $fname = test_input($_POST["fname"]);
  $lname = test_input($_POST["lname"]);
  $email = test_input($_POST["email"]);
  $website = test_input($_POST["website"]);
  $comment = test_input($_POST["comment"]);
  $cloud = test_input($_POST["cloud"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Cisco Metacloud Pivotal Cloud Foundry Webinar Registration Site</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  First Name: <input type="text" name="fname">
  Last Name: <input type="text" name="lname">
  <br><br>
  Company Name: <input type="text" name="company">
  <br><br>
  Your Title: <input type="text" name="title">
  <br><br>
  E-mail Address: <input type="text" name="email">
  <br><br>
  Company Website: <input type="text" name="website">
  <br><br>
  What is your interest Cisco Cloud Solutions and Cloud Foundry? <br><br><textarea name="comment" rows="5" cols="60"></textarea>
  <br><br>
  Current Cloud Provider:
  <input type="radio" name="cloud" value="AWS">AWS
  <input type="radio" name="cloud" value="Google">Google
  <input type="radio" name="cloud" value="Asure">Azure
  <input type="radio" name="cloud" value="Flexpod or Vblock">Flexpod or Vblock
  <input type="radio" name="cloud" value="VMWare">VMWare
  <br><br>
  <input type="submit" name="submit" value="submit">  
</form>

<?php

  echo "<h2>Conformation of your input and email will be sent:</h2>";
  echo $lname . " " . $lname; 
  echo "<br>";
  echo $company;
  echo "<br>";
  echo $email;
  echo "<br>";
  echo $title;
  echo "<br>";
  echo $website;
  echo "<br>";
  echo $comment;
  echo "<br>";
  echo $cloud;
  echo "<br>";
  
if(isset($_POST['submit']))
 {  
  // use actual sendgrid username and password in this section
  $url = 'https://api.sendgrid.com/'; 
  $user = 'biharper'; // place SG username here
  $pass = 'MetacloudSE1'; // place SG password here
  // grabs HTML form's post data; if you customize the form.html parameters then you will need to reference their new new names here
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $title = $_POST['title'];
  $message = $_POST['message'];
  // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
  // make the to email be your own address or where ever you would like the contact form info sent
  $params = array(
    'api_user'  => "$user",
    'api_key'   => "$pass",
    'to'        => "$email", // set TO address to have the contact form's email content sent to
    'subject'   => "Registration Confirmed", // Either give a subject for each submission, or set to $subject
    'html'      => "<html><head><title>Contact Form</title><body>
    First Name: $fname\n<br>
    Last Name: $lname\n<br>
    Email: $email\n<br>
    Title: $title\n<br>
    Company: $company\n<br>
    Subject: Webinar Confirmation - Pivotal Cloud Foundry\n<br>
    Message: You have been confirmed for the Cisco Metacloud Pivotal Cloud Foundry Webinar <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
    'text'      => "
    Name2: $name\n
    Email2: $email\n
    Company2: $company\n
    Subject2: $subject\n
    $message",
    'from'      => "Webinars-by-Cisco@cisco.com", // set from address here, it can really be anything
   );
  curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
  $request =  $url.'api/mail.send.json';
  // Generate curl request
  $session = curl_init($request);
  // Tell curl to use HTTP POST
  curl_setopt ($session, CURLOPT_POST, true);
  // Tell curl that this is the body of the POST
  curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
  // Tell curl not to return headers, but do return the response
  curl_setopt($session, CURLOPT_HEADER, false);
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
  // obtain response
  $response = curl_exec($session);
  curl_close($session);
  // print everything out
  //print_r($response);
  
 }
?>



</body>
</html>

