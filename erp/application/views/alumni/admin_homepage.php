 

<center>
<h1> List Of Admins </h1></center>
<br>

 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
			  
<table id="default-datatable" align="center" class="table table-bordered">
<thead>
<tr>
	<th> Serial NO </th>
	<th> Employee ID </th>
	<th> Name</th>
	<th> Mobile</th>
	<th> Email</th>
</tr>
</thead>
<tbody>
<?php $sno=1; foreach($alumni_admin as $admin){?>
<tr>
<td><?=$sno++?></td>
<td><?=$admin->employee_id_?></td>
<td><?=$admin->emp_name_?></td>
<td><?=$admin->emp_mobile_?></td>
<td><?=$admin->emp_mail_?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>
</div>
</div>
</div>