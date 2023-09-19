<div class="form-group col-md-6">
    <label for="{{$data[0]}}">{{$data[1]}}</label>
    <input type="file" class="form-control @error($data[0]) is-invalid @enderror"
        id="{{$data[0]}}" name="{{$data[0]}}">
    @error($data[0])
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>