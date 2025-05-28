<div style="padding-bottom: 10px;">
    <small class="text-uppercase">
        <i class="bi bi-person-workspace"></i>
        Frontliner's Dashboard
    </small>
</div>
<div class="row">
    @include('manager.manager_fl_overview')
</div>

<div style="padding-bottom: 10px; margin-top: 20px;">
    <hr>
    <small class="text-uppercase">
        <i class="bi bi-person-workspace"></i>
        Technician's Dashboard
    </small>
</div>

<div class="row">
    @include('manager.manager_tech_overview')
</div>

<div style="padding-bottom: 10px; margin-top: 20px;">
    <hr>
    <small class="text-uppercase">
        <i class="bi bi-person-workspace"></i>
        Spare Custodian's Dashboard
    </small>
</div>

<div class="row">
    @include('manager.manager_custodian_overview')
</div>
