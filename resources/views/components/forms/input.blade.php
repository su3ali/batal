@props([ 'name', 'type'=>'text', 'value'=>null, 'label'=>'', 'class'=>'', ])
@php
    $invalidClass =$errors->has(dotted_string($name)) ? 'is-invalid' : '';
    $splitAttributes = explode(' ',$attributes);
    $defaultPlaceHolder = t_('Enter :name',['name'=>$label]);
    $properties = [
    'class'=>"{$invalidClass} form-control {$class}" ,
    'placeholder'=> $defaultPlaceHolder,
    ...$splitAttributes,
    ];
@endphp
<div class="form-group mb-4">
    <label
        class="{{ $errors->has(dotted_string($name)) ? 'text-danger' : '' }}"> {{ $label }} {!!  data_get($attributes,'required') ? '<span class="tx-danger">*</span>':'' !!}</label>
    @if(!in_array($type,['file','password']))
        {!! Form::$type($name,$value,$properties) !!}
    @else
        {!! Form::$type($name,$properties) !!}
    @endif
    @error(dotted_string($name))
    <ul class="parsley-errors-list filled" id="{{$name}}parsley-id-32">
        <li class="parsley-required">
            {{ $message }}
        </li>
    </ul>
    @enderror
</div>
