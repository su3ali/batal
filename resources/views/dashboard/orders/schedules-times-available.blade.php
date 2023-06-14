@if($finalAvailTimes)

    @foreach($finalAvailTimes as $time)


@if($notAvailable->isNotEmpty())

    <div class="select-time">

        <label
            class="bg-btn-hover dark-hover fw-bold  radio"
            dir="{{get_current_lang()=='en'?'ltr':'rtl'}}"
            for="timeselect-{{$itr}}-{{$time->timestamp}}">
            <input name="start_time[{{$itr}}]" type="radio" class="btn-check time"
                                                         id="timeselect-{{$itr}}-{{$time->timestamp}}"
                                                         value="{{$time->timestamp}}" {{array_sum($notAvailable->pluck('quantity')->toArray()) === array_sum($service->pluck('count_group')->toArray()) && in_array($time->timestamp,$notAvailable->pluck('time')->toArray()) ? 'disabled' : ''}}>
           <span> {{$time->format('g:i A')}} </span>
        </label>
    </div>
@else

    <div class="select-time">

        <label
            class="bg-btn-hover dark-hover fw-bold  radio"
            dir="{{get_current_lang()=='en'?'ltr':'rtl'}}"
            for="timeselect-{{$itr}}-{{$time->timestamp}}">
            <input name="start_time[{{$itr}}]" type="radio" class="btn-check time"
                   id="timeselect-{{$itr}}-{{$time->timestamp}}"
                   value="{{$time->timestamp}}">
            <span> {{$time->format('g:i A')}} </span>
        </label>
    </div>
@endif

@endforeach

@else
    <div class="text-center">
        <img width="40%" src="{{asset('images/time.png')}}">
    </div>
@endif
