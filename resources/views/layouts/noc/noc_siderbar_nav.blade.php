Sidebar start
***********************************-->
<style nonce="{{ $cspNonce }}">
.font-size-csp-noc-fortyone{
    font-size:smaller;
 }

</style>
<div class="dlabnav">
    <div class="dlabnav-scroll">
      
        <ul class="metismenu" id="menu">
           
            <li><a href="{{ route('noc.profile') }}" class="" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text font-size-csp-noc-fortyone">Profile</span>
                </a>
            </li>
            <li><a href="{{ route('noc.add_noc_application_form') }}" class="" aria-expanded="false">
                <i class="fa fa-address-card" aria-hidden="true"></i>
                <span class="nav-text font-size-csp-noc-fortyone">Noc Application</span>
            </a>
        </li>

        
           <li><a href="{{ route('noc.nocForm_list') }}" class="" aria-expanded="false">
                <i class="flaticon-025-dashboard"></i>
                <span class="nav-text font-size-csp-noc-fortyone">Application Submitted</span>
            </a>
        </li>

               

            <li><a href="{{ route('noc.myapplication') }}" class="" aria-expanded="false">
                <i class="fa fa-address-card" aria-hidden="true"></i>
                <span class="nav-text font-size-csp-noc-fortyone">Noc Query Raised</span>
            </a>
        </li>

        <li><a href="{{ route('noc.noc_genrate_list_user') }}" class="" aria-expanded="false">
            <i class="fa fa-address-card" aria-hidden="true"></i>
            <span class="nav-text font-size-csp-noc-fortyone">NOC issued</span>
        </a>
    </li>
           

        </ul>
    </div>
</div>
