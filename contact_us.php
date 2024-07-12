<!DOCTYPE html>
<html>
<head>
  <title>Contact Us | SIMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Comic Sans MS, Comic Sans;
      margin: 0;
      padding: 20px;
      background: url(../images/bg-hero.png) no-repeat fixed 50%;
    }
    h1 {
      font-size: 28px;
      margin-bottom: 20px;
    }
    p {
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 15px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
    }
    .contact-section {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
    }
    .contact-info {
      flex-basis: 50%;
    }
    .contact-form {
      flex-basis: 50%;
    }
    .contact-info p {
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 15px;
    }
    .contact-form label {
      display: block;
      margin-bottom: 10px;
      font-size: 16px;
    }
    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 15px;
    }
    .contact-form button {
      background-color: #ff0000;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
    }
    .contact-form button:hover {
      background-color: #006cd9;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Contact Us - KCMT's SIMS</h1>
    <?php
      if(isset($_POST['submit'])){
        $to = "admin@ourwebprojects.site"; // Admin email address
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $subject = "New Contact Form Submission";
        
        $headers = "From: $name <$email>" . "\r\n" .
                    "Reply-To: $email" . "\r\n" .
                    "X-Mailer: PHP/" . phpversion();
        
        $mailBody = "Name: $name\nEmail: $email\n\n$message";
        
        if(mail($to, $subject, $mailBody, $headers)){
         echo "<script>alert('Message sent successfully! $name');</script>";
        } else{
          echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
        }
      }
    ?>
    <div class="contact-info">
        <p>Please feel free to reach out to us with any questions, concerns, or feedback:</p>
        <p>Email: <b>admin@ourwebprojects.site</b>	</p>
        <p>Phone: <b>+919470657612</b></p>
      </div>
    <div class="contact-section">
      
      <div class="contact-form">
        <form method="POST" action="">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="message">Message:</label>
          <textarea id="message" name="message" required></textarea>

          <button type="submit" name="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
