<div
    {{-- @if (isset($md))
    class={{"form-group col-md-".$md}}
    @else
    class="form-group col-md-6"
    @endif --}}
    @php
        if(isset($md)) {
            echo 'class="form-group col-md-'.$md.'"';
        } else {
            echo 'class="form-group col-md-6"';
        }
    @endphp
    @if (isset($style))
        style = {{"margin-top:".$style[0]}};
    @endif
>
    <label for="{{$data[0]}}">{{$data[1]}}</label>
    <input type="{{$data[3]}}" class="form-control @error($data[0]) is-invalid @enderror"
        id="{{$data[0]}}" name="{{$data[0]}}" placeholder="{{$data[2]}}" @if (isset($data[4]))
            value='{{old($data[0], $data[4])}}'
       @else value = '{{old($data[0])}}' @endif>
    @error($data[0])
        <span class="invalid-feedback"> {{$message}} </span>
    @enderror
</div>