<?php include('path.php'); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php");
guestsOnly();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
    .banner {
      display: none;
    }
  </style>
  <title>Login</title>
</head>

<body>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <div class="auth-content">

    <form action="login.php" method="post">
      <h2 class="form-title">Login</h2>

      <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

      <div>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
      </div>
      <div>
        <div class="g-recaptcha" data-sitekey="6LfmYkcpAAAAAJjarUpak9joQMFTSbS3HNDHTX9o"></div>
      </div>
      <div>
        <button type="submit" name="login-btn" class="btn btn-big">Login</button>
        <button type="button" id="login-fb" name="login-fb" class="btn btn-big">
          <i class="fab fa-facebook-f"></i> Login by Facebook
        </button>
      </div>
      <p>Or <a href="<?php echo BASE_URL . '/register.php' ?>">Sign Up</a></p>
    </form>

    <form action="login.php" method="post" style="display:none" id="fb-login">
    <input type="username" name="username" />
    <input type="password" name="password" />
    <input type="email" name="email" />
    <input type="uid" name="uid" />
    <input type="login-fb" name="login-fb" />
    </form>
  </div>


  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>

  <script type="module">
    // Import the functions you need from the SDKs you need
    import {
      initializeApp
    } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import {
      getAnalytics
    } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-analytics.js";
    import {
      getAuth,
      FacebookAuthProvider,
      GoogleAuthProvider,
      signInWithPopup
    } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";


    const firebaseConfig = {
      apiKey: "AIzaSyDDnln-2XiSe-IrBbrNjoDcJdrsJtY5Pbk",
      authDomain: "fbauth-btn.firebaseapp.com",
      projectId: "fbauth-btn",
      storageBucket: "fbauth-btn.appspot.com",
      messagingSenderId: "1023638936523",
      appId: "1:1023638936523:web:ffb3f3e57c32ac8ddf344e"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
    const auth = getAuth();

    const provider = new FacebookAuthProvider();

    //----- facebook login code start	  
    document.getElementById("login-fb").addEventListener("click", function() {

      signInWithPopup(auth, provider)
        .then((result) => {
          // The signed-in user info.
          const user = result.user;
          console.log("🚀 ~ .then ~ user:", user)

          // This gives you a Facebook Access Token. You can use it to access the Facebook API.
          const credential = FacebookAuthProvider.credentialFromResult(result);
          const accessToken = credential.accessToken;

          var form = document.getElementById("fb-login");

          // Set values for form elements
          form.elements['username'].value = user?.displayName;
          form.elements['password'].value = user?.uid;
          form.elements['email'].value = user?.providerData?.[0]?.email;
          form.elements['uid'].value = user?.uid;
          form.elements['login-fb'].value = 1;
          form.submit();
        })
        .catch((error) => {
          // Handle Errors here.
          const errorCode = error.code;
          const errorMessage = error.message;
          console.log(errorMessage);
          // The email of the user's account used.
          const email = error.customData.email;
          // The AuthCredential type that was used.
          const credential = FacebookAuthProvider.credentialFromError(error);

        });
    });
  </script>
</body>

</html>