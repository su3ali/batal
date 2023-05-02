@foreach($times as $time)

    <div class="select-time">

        <label
            class="bg-btn-hover dark-hover fw-bold  radio"
            dir="{{get_current_lang()=='en'?'ltr':'rtl'}}"
            for="timeselect-{{$time->timestamp}}">
            <input name="start_time" type="radio" class="btn-check time"
                                                         id="timeselect-{{$time->timestamp}}"
                                                         value="{{$time->timestamp}}" {{in_array($time->timestamp,$notAvailable) ? 'disabled' : ''}}>
           <span> {{$time->format('g:i A')}} </span>
        </label>
    </div>

@endforeach
