<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <title>SIMS</title>
  <link rel="icon" type="image/x-icon" href="car.png">
  <style>
    html * {
      font-family: Comic Sans MS, Comic Sans;
    }
    body {
      background-color: white;
      background:url(bg-hero.png)no-repeat fixed 50%;
    }
    a {
      text-decoration: none;
    }
    /* NAVBAR STYLING STARTS */
    .navbar {
       display: flex;
      align-items: center;
      justify-content: space-between;
      /*padding: 20px;*/
      background-color: #ff0000;
      color: #fff;
    }
    .nav-links a {
      color: #fff;
    }
    /* LOGO */
    .logo {
      font-size: 32px;
    }
    /* NAVBAR MENU */
    .menu {
      display: flex;
      gap: 1em;
      font-size: 18px;
    }
    .menu li:hover {
      background-color: #006cd9;
      border-radius: 5px;
      transition: 0.3s ease;
    }
    .menu li {
      padding: 5px 14px;
      list-style-type: none;
    }
    /*RESPONSIVE NAVBAR MENU STARTS*/
    /* CHECKBOX HACK */
    input[type=checkbox]{
      display: none;
    } 
    /*HAMBURGER MENU*/
    .hamburger {
      display: none;
      font-size: 24px;
      user-select: none;
    }
    /* APPLYING MEDIA QUERIES */
    @media (max-width: 1260px) {
      .menu { 
        display:none;
        position: absolute;
        background-color:#ff0000;
        right: 0;
        left: 0;
        text-align: center;
        padding: 16px 0;
      }
      .menu li:hover {
        display: inline-block;
        background-color:#4c9e9e;
        transition: 0.3s ease;
      }
      .menu li + li {
        margin-top: 12px;
      }
      input[type=checkbox]:checked ~ .menu{
        display: block;
      }
      .hamburger {
        display: block;
      }
      .dropdown {
        left: 50%;
        top: 30px;
        transform: translateX(35%);
      }
      .dropdown li:hover {
        background-color: #4c9e9e;
      }
      /* Adjust image size for smaller devices */
      .center img {
        width: 80%; /* Adjust the width as needed */
      }
    }
    .card {
      /*box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);*/
      transition: 0.3s;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      text-align: center;
    }
    
    .container {
      padding: 2px 16px;
    }
    .center {
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 40%;
    }
    /* Elegant Login Button */
    .login-button {
      display: block;
      width: 120px;
      padding: 10px;
      background-color: #ff0000;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
      margin: 20px auto;
    }
    .login-button:hover {
      background-color: #006cd9;
    }
    /* Text Alignment */
    .typed-text {
      width: 100%; /* Adjust the width as needed */
      margin: 0 auto;
      text-align: justify;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <!-- LOGO -->
    <div class="logo">
      <i class='bx bxs-school bx-fade-down'></i>
      <span class="logo_name"><b>SIMS</b></span>
    </div>
    <!-- NAVIGATION MENU -->
    <ul class="nav-links">
      <!-- USING CHECKBOX HACK -->
      <input type="checkbox" id="checkbox_toggle" />
      <label for="checkbox_toggle" class="hamburger">&#9776;</label>
      <!-- NAVIGATION MENUS -->
      <div class="menu">
        <li><a href="index.php">Home</a></li>
        <!--<li><a href="about_us.php">Team</a></li>-->
        <li><a href="login.php">Login</a></li>
        <li><a href="contact_us.php">Contact</a></li>
      </div>
    </ul>
  </nav>
  <div class="card">
    <br>
    <br>
    <img src="kcmt.png" alt="Avatar" class="center">
    <div class="container">
      <h4><b>KCMT's SIMS</b></h4> 
      <div class="typed-text">
        <p id="typed-text">KCMT's SIMS is a comprehensive platform designed to streamline administrative tasks and facilitate seamless communication between college administrators and faculty members. With distinct modules tailored for both college administrators and faculty, the system offers a user-friendly interface for efficient management of faculty allotments and school information retrieval. These requirements were later used to design the system by creating data flow diagrams and entity relationship diagrams. The designed system was implemented using different development tools which include HTML for creating interfaces, CSS for styling web pages for dynamism in the web pages and as an input validation tool. XAMMP was used to build the database and PHP used as a server side scripting language to connect the user interfaces to the database.</p>
      </div>
      <a href="login.php" class="login-button">Login</a>
    </div>
  </div>

 <!-- <script>
    var typedText = `KCMT's SIMS is a comprehensive platform designed to streamline administrative tasks and facilitate seamless communication between college administrators and faculty members. With distinct modules tailored for both college administrators and faculty, the system offers a user-friendly interface for efficient management of faculty allotments and school information retrieval. These requirements were later used to design the system by creating data flow diagrams and entity relationship diagrams. The designed system was implemented using different development tools which include HTML for creating interfaces, CSS for styling web pages for dynamism in the web pages and as an input validation tool. XAMMP was used to build the database and PHP used as a server side scripting language to connect the user interfaces to the database.`;

    var i = 0;
    var speed = 50;

    function typeWriter() {
      if (i < typedText.length) {
        document.getElementById("typed-text").innerHTML += typedText.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
      }
    }

    typeWriter();
  </script>-->
  
</body>
</html>
