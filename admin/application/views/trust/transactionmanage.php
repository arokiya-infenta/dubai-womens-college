<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Manage Transactions</h4>
		    <!--<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Rocker</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
         </ol>-->
	   </div>
	   <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <a href="<?=site_url();?>/Trust/addTransactions" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-cog mr-1"></i> Add Transactions</a>
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
            <div class="card-header"><i class="fa fa-table"></i> Transactions</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Request number</th>
                        <th>Date</th>
                        <th>Request Category </th>
                        <th>Amount</th>
                        <th>Effective from</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>201124</td>
                        <td>2020/04/25</td>
                      
                        <td>Medical</td>
                        <td>9000</td>
                        <td>Will Smith</td>
                        <td>
                        <button class="btn btn-danger">X</button> 
                        <a href="<?=site_url()?>/Trust/editTransactions" class="btn btn-info">Edit</a></td>
                    </tr>
                    <tr>
                        <td>201129</td>
                        <td>2020/04/26</td>
                      
                        <td>Education</td>
                        <td>80000</td>
                        <td>Robert Downey</td>
                        <td>
                        <button class="btn btn-danger">X</button> 
                        <a href="<?=site_url()?>/Trust/editTransactions" class="btn btn-info">Edit</a></td>
                    </tr>
                    <tr>
                        <td>201125</td>
                        <td>2020/04/27</td>
                      
                        <td>Distress</td>
                        <td>14000</td>
                        <td>Trump</td>
                        <td>
                        <button class="btn btn-danger">X</button> 
                        <a href="<?=site_url()?>/Trust/editTransactions" class="btn btn-info">Edit</a></td>
                    </tr>
               
                </tbody>
                <tfoot>
                     <tr>
                        <th>Request number</th>
                        <th>Date</th>
                        <th>Request Category </th>
                        <th>Amount</th>
                        <th>Effective from</th>
                        
                        <th>Action</th>
                    </tr>
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