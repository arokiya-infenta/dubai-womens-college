<?php
/**
 * Created by PhpStorm.
 * User: troot
 * Date: 1/2/15
 * Time: 10:05 PM
 */

require('inc/dbPlayer.php');
require('inc/sessionManager.php');
$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["btnLogin"])) {

        $db = new \dbPlayer\dbPlayer();
        $msg = $db->open();

        if ($msg == "true") {
            $userPass = md5("hms2015".$_POST['password']);
            $loginId = $_POST["email"];
            $query = "select loginId,userGroupId,password,name,userId from users where loginId='" . $loginId . "' and password='" . $userPass . "'";
            var_dump($query);
            $result = $db->getData($query);
            //var_dump($result);
            $info = array();
            while ($row = mysql_fetch_assoc($result)) {

                array_push($info, $row['loginId']);
                array_push($info, $row['userGroupId']);
                array_push($info, $row['password']);
                array_push($info, $row['name']);
                array_push($info, $row['userId']);

            }
            //$db->close();
            $ses = new \sessionManager\sessionManager();
			$ses->start();
                $ses->Set("loginId", $info[0]);
                $ses->Set("userGroupId", $info[1]);
                $ses->Set("name", $info[3]);
                $ses->Set("userIdLoged", $info[4]);
            if (is_null($info[0])) {
                $msg = "Login Id or Password Wrong!";

            }
            else
            {
                
            }
            if($info[1]=="UG004")
            {
                header('Location: http://localhost/hms/sdashboard.php');
            }
            elseif($info[1]=="UG003")
            {

                header('Location: http://localhost/hms/edashboard.php');
            }
            else
            {
                header('Location: http://localhost/hms/dashboard.php');
            }


        }

    }
}
?>

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
	
	
    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="login-panel panel panel-default">

                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-2">
                           <a href="index.html" target="_self"><img src="./dist/images/logo.png" alt="Logo"></a>
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-10">
                            <h4 class="pTitle">Hostel Management System</h4>
                            </div>
                    </div>


                </div>
                <div class="panel-body">
                    <form name="login" action="index.php" accept-charset="utf-8" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail/Login ID" name="email" type="text" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                                <a href="forget.html" class="red pull-right">Forget Password</a>
                                <label id="loginMsg" class="red"><?php echo $msg ?></label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->

                            <button type="submit" name="btnLogin" class="btn btn-lg btn-success btn-block"><i class="glyphicon glyphicon-log-in"></i> Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
	
</div>
</div>


<!-- jQuery -->
<script src="./dist/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="./dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="./dist/js/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript
<script src="./dist/js/raphael-min.js"></script>
<script src="./dist/js/morris.min.js"></script>
<script src="./dist/js/morris-data.js"></script>
 -->
<!-- Custom Theme JavaScript -->
<script src="./dist/js/sb-admin-2.js"></script>

</body>

</html>
