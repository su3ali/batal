<h1 style="text-align: center; margin-top:5px">
    @if(app()->getLocale() == 'ar')
    {{\App\Models\Setting::first()->site_name_ar}}
    @else
        {{\App\Models\Setting::first()->site_name_en}}
    @endif
</h1>
<h3>{{t_('You can edit profile from Code')}} : {{$code}} </h3>


