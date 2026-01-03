<div class="list-group list-group-transparent mb-0">
    
    <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action d-flex align-items-center ">
        <i class="fe fe-settings mr-2"></i> @lang('Settings')
    </a>
     <a href="{{ route('settings.resumetemplate.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fe fe-package mr-2"></i> @lang('Resume Templates')
        </a>
    <a href="{{ route('settings.resumetemplatecategories.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fe fe-package mr-2"></i> @lang('Resume Categories')
        </a>
    <a href="{{ route('settings.packages.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fe fe-package mr-2"></i> @lang('Packages')
        </a>
    <a href="{{ route('settings.payments') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fe fe-dollar-sign mr-2"></i> @lang('Payments')
        </a>
     
    <a href="{{ route('settings.users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fe fe-users mr-2"></i> @lang('Users')
    </a>
    
    <a href="{{ route('settings.localization') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fe fe-volume-2 mr-2"></i> @lang('Localization')
    </a>
    <a href="{{ route('settings.email') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fe fe-mail mr-2"></i> @lang('E-mail Settings')
    </a>
    <a href="{{ route('settings.integrations') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fe fe-code mr-2"></i> @lang('Integrations')
    </a>
    
    <a href="{{ route('settings.update_check') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fe fe-alert-circle mr-2"></i>@lang('Update')
        </a>
</div>