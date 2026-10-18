@extends('layouts.admin.ssa_master')
   <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ url('public/css/app.css') }}" rel="stylesheet">
@section('content')
  <div class="content-bodys">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center border main-tital rounded-top-4 py-5">
                    <h2 class="text-dark">Quarterly Report of the State/UT Appropriate Authority – Upload Signed PDF File</h2>
                </div>
            </div>
                 <!-- Display success message -->
                                                    
                            <form id="quarterlyReportForm" name="quarterlyReportForm" action="http://localhost/art/Quarterly-report-form" method="POST"> 
                 <input type="hidden" name="_token" value="WbikQKVjIy3RfD0aXmtjRsPtRu4jhvLjGZFbTwbw" autocomplete="off">  
                <div class="border p-2 p-lg-4 rounded-bottom-3 bg-white mb-4 shadow-sm">
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="col-md-3">
                                <div class="mb-3">
                                <label for="formFileSm" class="form-label">Download PDF File</label><br />
                                 <a class="btn btn-danger" href="javascript:void(0)" id="loadpdffile"></i>Download PDF File</a>
                
                                </div>
                            </div>                             
                            <div class="col-md-3">
                                <div class="mb-3">
                                <label for="formFileSm" class="form-label">Upload Signed PDF File</label>
                                <input class="form-control form-control-sm" id="upload_sign_pdf" name="upload_sign_pdf" type="file">
                                </div>
                            </div>                                                            
                            <div class="col-md-1">
                                <div class="mb-2 pt-2">
                                <span>&nbsp; &nbsp;<a class="link btn btn-primary csp-clinic-btn-blue" id="submitfilter">Submit</a></span>							 
                                </div>
                            </div> 
                        </div>  

                    
                    </div>
                    <div class="row" id="resultDiv" >
                        <embed src="https://dhr.gov.in/sites/default/files/whats_new/01012026/Recruitment_Scientist-G.pdf" style="width:100%; height: 820px;" type='application/pdf' title="Whats new">
                    </div>  
                </div>            
            </form>     
        </div>
    </div>
</div> 
 
@endsection
