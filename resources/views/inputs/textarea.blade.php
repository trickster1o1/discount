<div @if(isset($data[4])) class='{{"form-group col-".$data[4]}}' @else class='form-group col-md-6' @endif>
    <div class="form-floating">
        <label for="{{$data[0]}}">{{$data[1]}}</label>
        <textarea class="form-control  @error($data[0]) is-invalid @enderror" name="{{$data[0]}}" placeholder="{{$data[2]}}" id="{{$data[0]}}" @if(isset($data[5])) rows='{{$data[5]}}' @endif >@if(isset($data[3])){{old($data[0],$data[3])}} @else {{old($data[0])}} @endif</textarea>
        @error($data[0])
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    
</div>