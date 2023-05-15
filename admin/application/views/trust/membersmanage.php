<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Manage Members</h4>
		    <!--<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Rocker</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
         </ol>-->
	   </div>
	   <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <a href="<?=site_url();?>/Trust/addMember" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-cog mr-1"></i> Add Members</a>
       <!-- <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown">
        <span class="caret"></span>
        </button>
        <div class="dropdown-menu">
          <a href="javaScript:void();" class="dropdown-item">Action</a>
          <a href="javaScript:void();" class="dropdown-item">Another action</a>
          <a href="javaScript:void();" class="dropdown-item">Something else here</a>
          <div class="dropdown-divider"></div>
          <a href="javaScript:void();" class="dropdown-item">Separated link</a>
        </div>-->
      </div>
     </div>
     </div>



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Members</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Employee Name</th>
                        <th>Relationship </th>
                        <th>mobile</th>
                        <th>Date of Joining</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>9994821933</td>
                        <td>2011/04/25</td>
                        <td><button class="btn btn-danger">X</button> <a href="<?=site_url()?>/Trust/editMember" class="btn btn-info">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>9578884885</td>
                        <td>2011/07/25</td>
                        <td><button class="btn btn-danger">X</button> <a href="<?=site_url()?>/Trust/editMember" class="btn btn-info">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>9791606505</td>
                        <td>2009/01/12</td>
                        <td><button class="btn btn-danger">X</button> <a href="<?=site_url()?>/Trust/editMember" class="btn btn-info">Edit</a></td>
                    </tr>
               
                </tbody>
                <tfoot>
                    <tr>
                    <th>Title</th>
                        <th>Employee Name</th>
                        <th>Relationship </th>
                        <th>mobile</th>
                        <th>Date of Joining</th>
                        <th>Action</th>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>