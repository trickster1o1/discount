

        <div class="form-group form-group-sm col-md-6">
            <label for="{{$data[0]}}">{{$data[1]}}</label>
            <input type="time" class="form-control @error($data[0]) is-invalid @enderror"
                id="{{$data[0]}}" name="{{$data[0]}}" placeholder="Enter Store Name" @if(isset($data[2])) value="{{old($data[0],$data[2])}}" @else value="{{old($data[0])}}" @endif >
            @error($data[0])
                <span class="invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>     