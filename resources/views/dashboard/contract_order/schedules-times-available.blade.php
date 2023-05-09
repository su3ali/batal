
@foreach($times as $time)


@if($notAvailable->isNotEmpty())

    <div class="select-time">

        <label
            class="bg-btn-hover dark-hover fw-bold  radio"
            dir="{{get_current_lang()=='en'?'ltr':'rtl'}}"
            for="timeselect-{{$time->timestamp}}">
            <input name="start_time" type="radio" class="btn-check time"
                                                         id="timeselect-{{$time->timestamp}}"
                                                         value="{{$time->timestamp}}" {{array_sum($notAvailable->pluck('quantity')->toArray()) === $package->visit_number && in_array($time->timestamp,$notAvailable->pluck('time')->toArray()) ? 'disabled' : ''}}>
           <span> {{$time->format('g:i A')}} </span>
        </label>
    </div>
@else

    <div class="select-time">

        <label
            class="bg-btn-hover dark-hover fw-bold  radio"
            dir="{{get_current_lang()=='en'?'ltr':'rtl'}}"
            for="timeselect-{{$time->timestamp}}">
            <input name="start_time" type="radio" class="btn-check time"
                   id="timeselect-{{$time->timestamp}}"
                   value="{{$time->timestamp}}">
            <span> {{$time->format('g:i A')}} </span>
        </label>
    </div>
@endif

@endforeach
