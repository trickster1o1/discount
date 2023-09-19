<div class="form-group col-md-6">
    <label for="{{$data[0]}}">{{$data[1]}}</label>
    <input type="text" class="form-control datepicker @error($data[0]) is-invalid @enderror"
        id="{{$data[0]}}" name="{{$data[0]}}" @if(isset($data[2])) value='{{old($data[0],$data[2])}}' @else value='{{old($data[0])}}' @endif >
    @error($data[0])
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>