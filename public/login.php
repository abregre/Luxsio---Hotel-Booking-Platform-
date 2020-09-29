<?php
  require __DIR__.'/../boot/boot.php';

  use Hotel\User;
  //Check for existing log
  if(!empty(User::getCurrentUserId())){
    header('Location: /public/index.php'); 
  }
?>
<?php include('inc/header.php'); ?>
    <main>
      <div class="main-container">
        <div id="overlay"></div>
        <div class="login-wrapper">
          <div class="login-container" id="login-container">
            <div class="login-form-container sign-up-container">
              <form action="actions/register.php" method='post'>
                <h1>Create Account</h1>
                <?php if(!empty($_GET['error'])): ?>
                  <div class="error">Register Error</div>
                <?php endif  ?>
                <input type="text" placeholder="Name" name='name'/>
                <input type="email" placeholder="Email" name='email' id='email'/>
                <input type="email" placeholder="Email again" id='email_repeat'/>
                <input type="password" placeholder="Password" name='password' id='password'/>
                <input type="password" placeholder="Password again" id='password_repeat'/>
                <button type='submit'>Sign Up</button>
              </form>
            </div>
            <div class="login-form-container sign-in-container">
              <form action="actions/login.php" method='post'>
                <h1>Sign in</h1>
                <?php if(!empty($_GET['error'])): ?>
                  <div class="error">Login Error</div>
                <?php endif  ?>
                <input type="email" placeholder="Email" name='email'/>
                <input type="password" placeholder="Password" name='password'/>
                <button type='submit'>Sign In</button>
              </form>
            </div>
            <div class="overlay-container">
              <div class="overlay-login">
                <div class="overlay-panel overlay-left">
                  <h1>Welcome Back!</h1>
                  <p>
                    To keep connected with us please login with your personal
                    info
                  </p>
                  <button class="ghost" id="signIn" >Sign in</button>
                </div>
                <div class="overlay-panel overlay-right">
                  <h1>Hello, Visitor!</h1>
                  <p>Enter your personal details and start journey with us</p>
                  <button class="ghost" id="signUp">Sign Up</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs-mobile">
          <input type="radio" name="tabs" id="tabone" checked="checked" />
          <label for="tabone">Login</label>
          <div class="tab">
            <h1>Welcome Back!</h1>
            <p>
              To keep connected with us please login with your personal info
            </p>
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Password" />
            <button><a href="profile.html">Sign In</a></button>
          </div>
          <input type="radio" name="tabs" id="tabtwo" />
          <label for="tabtwo">Sign Up</label>
          <div class="tab">
            <h1>Hello, Visitor!</h1>
            <p>Enter your personal details and start journey with us</p>
            <input type="text" placeholder="Name" />
            <input type="email" placeholder="Email" />
            <input type="email" placeholder="Email again" />
            <input type="password" placeholder="Password" />
            <input type="password" placeholder="Password again" />
            <button><a href="#"> Sign Up</a></button>
          </div>
        </div>
      </div>
    </main>

    <?php include('inc/footer.php'); ?>