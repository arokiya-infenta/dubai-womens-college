<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<body>
    <div id="login">
        <br>
        <br>
        <br>
             <img src="https://mssw.in/wp-content/uploads/2020/03/mssw_logo_full.png" >
        <div class="container">
       <?=$this->session->flashdata('message')?>
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="<?=base_url()?>Welcome/LoginDetails" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" required name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" required name="password" id="password" class="form-control">
                            </div>
                            <!--<div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>-->
                                <input type="submit" name="submit" class="btn btn-clor btn-md" value="submit">
                            </div>
                            <!--<div id="register-link" class="text-right">
                                <a href="#" class="text-info">Forgot Password</a>
                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #fafafa;
  height: 100vh;
}
img{



  
    height: 141px;
      display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;



}
.text-info {
    color: #10117b!important;
}
.btn-clor {
    color: #fff;
    background-color: #11137c;
    border-color: #060862;
}
#login .container #login-row #login-column #login-box {
  margin-top: 90px;
  max-width: 600px;
  height: 320px;
  border: 1px solid #9C9C9C;
  background-color: #EAEAEA;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
#login .container #login-row #login-column #login-box #login-form #register-link {
  margin-top: -85px;
}
</style>