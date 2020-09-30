<?php
  require __DIR__.'/../boot/boot.php';

  use Hotel\User;
  //Check for existing log
  if(!empty(User::getCurrentUserId())){
    header('Location: /index.php'); 
  }
?>
<?php include('inc/header.php'); ?>
    <main>
      <div class="main-container">
        <div id="overlay"></div>
        <div class="login-wrapper">
          <div class="login-container" id="login-container">
            <div class="login-form-container sign-up-container">
              <form action="actions/register.php" method='post' id='registerForm'>
                <h1>Create Account</h1>
                <label for="name">Name</label>           
                <input type="text" placeholder="Name" name='name' required id="registerName"/>
                <span>Name should be from 3-15 characters only</span>
                <label for="email">Email</label>           
                <input type="email" placeholder="Email" name='email' id='registerEmail' required/>
                <span>Not Valid Email</span>
                <label for="email">Email Again</label>           
                <input type="email" placeholder="Email again" id='registerEmailRepeat' required/>
                <span>Emails don't match</span>
                <label for="password">Password</label>           
                <input type="password" placeholder="Password" name='password' id='registerPassword' required/>
                <span>Password must have at least 6 characters</span>
                <label for="password">Password Again</label>           
                <input type="password" placeholder="Password again" id='registerPasswordRepeat' required/>
                <span>Passwords don't match</span>
                <button type='submit'>Sign Up</button>
              </form>
            </div>
            <div class="login-form-container sign-in-container">
              <form action="actions/login.php" method='post'>
              <h1>Sign in</h1>               
              <label for="email">Email</label>           
              <input type="email" placeholder="Email" name='email' required/>
              <label for="password">Password</label>           
                <input type="password" placeholder="Password" name='password' required/>
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
            <form action="actions/login.php" method='post'>
                <input type="email" placeholder="Email" name='email' required/>
                <input type="password" placeholder="Password" name='password' required/>
                <button type='submit'>Sign In</button>
              </form>
          </div>
          <input type="radio" name="tabs" id="tabtwo" />
          <label for="tabtwo">Sign Up</label>
          <div class="tab">
            <h1>Hello, Visitor!</h1>
            <p>Enter your personal details and start journey with us</p>
            <form action="actions/register.php" method='post'>
                <input type="text" placeholder="Name" name='name' required/>
                <input type="email" placeholder="Email" name='email' id='email' required/>
                <input type="email" placeholder="Email again" id='email_repeat' required/>
                <input type="password" placeholder="Password" name='password' id='password' required/>
                <input type="password" placeholder="Password again" id='password_repeat' required/>
                <button type='submit'>Sign Up</button>
              </form>
          </div>
        </div>
      </div>
    </main>

    <?php include('inc/footer.php'); ?>