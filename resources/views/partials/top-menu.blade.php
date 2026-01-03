<div class="row">

    <div class="col-sm-5">
            
        
    </div> 
    <div class="col-sm-7 text-right">
        <div class="btn-top">
                
                    
                
        </div>
    </div>
    
</div>

<div class="header d-lg-flex p-0 collapse" id="headerMenuCollapse">
        <div class="container">
          <div class="row align-items-center">
                <div class="col-lg-3 ml-auto">
                        <form method="get" action="{{ route('resume.index') }}" class="input-icon my-3 my-lg-0">
                          <input type="search" name="search" value="{{ Request::get('search') }}" class="form-control header-search" placeholder="@lang('Search resume')" tabindex="1">
                          <div class="input-icon-addon">
                            <i class="fe fe-search"></i>
                          </div>
                        </form>
                      </div>
            
            <style>
            .btn-menu-header a{
                margin-right: 5px;
                margin-top: 10px;
            }
            </style>
            <div class="col-lg order-lg-first">
              <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                <li class="nav-item btn-menu-header">
                        <a href="{{ route('resume.index') }}" class="btn btn-primary">
                                <i class="fe fe-file"></i>  @lang('Resumes')
                            </a>
                            
                            <a href="{{ route('resume.template') }}" class="btn btn-primary">
                                    <i class="fe fe-plus"></i>  @lang('Resume create')
                            </a>
                            <a class="btn btn-info" href="{{ route('billing.index') }}">
                              <i class="fe fe-credit-card"></i> @lang('Billing')
                            </a>
                           
                        @can('admin')
                        <a href="{{ route('settings.index') }}" class="btn btn-outline-primary">
                            <i class="fe fe-shield"></i> @lang('Administrator')
                        </a>
                        @endcan
                </li>
                
              </ul>
            </div>
          </div>
        </div>
      </div>