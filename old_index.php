
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords"
    content="jigar sable, portfolio, jigar, full stack dev, personal portfolio lifecodes, portfolio design, portfolio website, personal portfolio" />
  <meta name="description" content="Welcome to Jigar's Portfolio. Full-Stack Web Developer and Android App Developer" />
  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9; /* Light red background */
      color: #333;
    }

    header {
      background-color:  #006cd9; /* Dark red header */
      color: white;
      text-align: center;
      padding: 10px;
    }

    marquee {
      font-size: 1.2rem;
      padding: 10px;
    }

    section.home {
      position: relative;
      height: 80vh;
      text-align: center;
      overflow: hidden;
    }

    #particles-js {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .content {
      position: absolute;
      display:flex;
      text-align: center;
      justify-content:center;
      color:#006cd9;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1;
      width: 100%;
    }

    .container{
      font-size: 2em;
      padding:1px;
      margin-bottom: 20px;
      color: #fff;
    }
    .new_btn{
        padding:20px;
    }

    .rang{
        color:#006cd9;
    }

    span {
      color: #54BAB9; /* Light red span color */
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: .5em;
      font-weight:100px;
      text-decoration: none;
      color: black;
      background-color: #BCA37F; /* Dark red button */
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color:#113946; /* Slightly lighter shade on hover */
      color:white;
    }

    .social-icons {
      list-style: none;
      padding: 0;
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .social-icons a {
      text-decoration: none;
      color: #333;
      font-size: 1.5em;
    }

    .image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('./kcmt.jpg') center/cover no-repeat;
      filter: blur(7px);
      z-index: 0;
    }
    footer{
        background-color: #006cd9; 
        color: white; 
        text-align: center; 
        padding: 20px;"
    }
  </style>
 
  
  <title>Deeksha Workshop</title>
</head>

<body>

  <header>
    <marquee loop="alternet" scrollamount="20" behavior="scroll" direction="left">
      ॐ भूर् भुवः स्वः। &nbsp;&nbsp;&nbsp; तत् सवितुर्वरेण्यं। &nbsp;&nbsp;&nbsp; भर्गो देवस्य धीमहि।
      &nbsp;&nbsp;&nbsp; धियो यो नः प्रचोदयात् ॥
    </marquee>
  </header>

  <section class="home" id="home">
    <div id="particles-js"></div>
    <div class="image"></div>

    <div class="content">
        <div class= "container"><span id="element"></span>
      <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

     
<script>
  var typed = new Typed('#element', {
       strings: ['<b>Hi There</b>', '<b>I am DEEKSHA PROGRAM</b>'],
    typeSpeed: 80,
    loop:true,
  });
</script>
 
          <div class="new_btn">
              <a href="login.php" class="btn">LOGIN
        <i class="fas fa-arrow-circle-down"></i>
      </a>
          </div>
      
    </div>
  </section>
<footer>
    <div>
      <p>&copy; 2023 Deeksha Workshop. All rights reserved.</p>
      <p>Website designed by Prahlad Singh & Kuldeep Gangwar </p>
    </div>
  </footer>
 
</body>

</html>
