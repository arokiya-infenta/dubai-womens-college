<!doctype html>
			<html lang="en">
			<head>
			<meta charset="UTF-8">
			<title>MSSW</title>
			
			<style type="text/css">
				h5{
  color: #000000;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 3px;
  margin-top: -3px;
}
table{
  width:100%;
  table-layout: fixed;
}
.tbl-header{
  background-color: #ffffff;
 }
.tbl-content{
  margin-top: 0px;
  border: 1px solid rgba(255,255,255,0.3);
}
th{
  padding: 8px 3px;
  text-align: left;
  font-size: 12px;
  color: #000000;
  text-transform: uppercase;
}
td{
  padding: 5px;
  text-align: left;
  vertical-align:middle;
  font-size: 12px;
  color: #000000;
  border-bottom: solid 1px rgba(255,255,255,0.1);
}
table tr:last-child td {
    border-bottom: thin solid; 
}
tr td:first-child {
     border-left: thin solid;
}

table td:last-child {
     border-right: thin solid;
}
table th {
    border-top: thin solid; 
}
tr th:first-child {
     border-left: thin solid;
}

tr th:last-child {
     border-right: thin solid;
}

/* demo styles */

@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
body{
  background: -webkit-linear-gradient(left, #fafbfb, #edf0f0);
  background: linear-gradient(to right, #dee4e4, #d0dede);
  font-family: 'Roboto', sans-serif;
}
section{
  margin: 5px;
}


/* follow me template */
.made-with-love {
  margin-top: 8px;
  padding: 3px;
  clear: left;
  text-align: center;
  font-size: 10px;
  font-family: arial;
  color: #000000;
  position:absolute;
   bottom:0;
}
.made-with-love a {
  color: #000000;
  text-decoration: none;
}
.made-with-love a:hover {
  text-decoration: underline;
}
#center {  
  text-align: center;
  margin-top: -40px;
 }
		
			</style>
			
			</head>
			<body>  
			<div id ="center">
			<img src="https://localhost/mssw/admin/system/image/logo1.png" style="text-align:center;" alt="image">
			</div>
			<section>
  <!--for demo wrap-->
  <?php date_default_timezone_get();
	$date=date('d-M-Y'); ?>
  <h5><b>Admission 2021</b></h5>
  <h5><b>Application Fees as on <?=$date?></b></h5>
  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0">
      <thead>
		<tr style="border:1px solid black;background-color:#004953;">
          <th><b style="color:white;">Program</b></th>
          <th><b style="color:white;">Fees(Rs)</b></th>
		  <th></th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
	    <tr>
          <td colspan="3"><b>UG</b></td>
        </tr>
        <tr>
          <td>B.S.W (SF)</td>
          <td><?=$ugbsw1?></td>
          <td></td>
        </tr>
        <tr>
          <td>B.Sc Psychology (SF)</td>
          <td><?=$ugbsc1?></td>
		  <td></td>
        </tr>
        <tr>
          <td colspan="3"><b>PG - MSW Aided</b></td>
        </tr>
		<tr>
          <td>MSW Community Development</td>
          <td><?=$msw_aid_cm?></td>
          <td></td>
        </tr>
        <tr>
          <td>MSW Medical & Psychiatric Social Work</td>
          <td><?=$msw_aid_cm?></td>
		  <td></td>
        </tr>
        <tr>
          <td>MSW Human Resource Management</td>
          <td><?=$msw_aid_cm?></td>
		  <td></td>
        </tr>	
		<tr>
          <td colspan="3"><b>PG - Self Finance</b></td>
        </tr>
        <tr>
          <td>MAHRM</td>
          <td><?=$mahrm1?></td>
          <td></td>
        </tr>
        <tr>
          <td>MAHRMOD</td>
          <td><?=$mahrmod1?></td>
		  <td></td>
        </tr>
		<tr>
          <td>MASE</td>
          <td><?=$mase1?></td>
          <td></td>
        </tr>
        <tr>
          <td>MADM</td>
          <td><?=$madm1?></td>
		  <td></td>
        </tr>
		<tr>
          <td>M.SC CP</td>
          <td><?=$msccp1?></td>
          <td></td>
        </tr>
        <tr>
          <td>MSWDE</td>
          <td><?=$mswde1?></td>
		  <td></td>
        </tr>
		<tr>
          <td>MSW Community Development</td>
          <td><?=$msw_self_cm?></td>
          <td></td>
        </tr>
        <tr>
          <td>MSW Medical & Psychiatric Social Work</td>
          <td><?=$msw_self_mepy?></td>
		  <td></td>
        </tr>
        <tr>
          <td>MSW Human Resource Management</td>
          <td><?=$msw_self_hrm?></td>
		  <td></td>
        </tr>
        <tr>
          <td colspan="3"><b>PG - Diploma</b></td>
        </tr>
		<tr>
          <td>Personnel Management & Industrial Relations (SF)</td>
          <td><?=$pgdipir1?></td>
          <td></td>
        </tr>
        <tr>
          <td>Human Resource Management (SF)</td>
          <td><?=$pgdiphr1?></td>
		  <td></td>
        </tr>
		<tr>
          <td><b>TOTAL</b></td>
          <td><b><?=$total?></b></td>
          <td></td>
        </tr>	
      </tbody>
    </table>
  </div>
</section>


<!-- follow me template -->
<div class="made-with-love">
  <a>32, Casa Major Road, Egmore, Chennai – 600 008</a>
</div>

			</body>
			</html>