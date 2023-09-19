        <div class="form-group form-group-sm col-md-6">
            <label for="sch">{{$data[1]}}</label>
            <input type="text" class="timepicker form-control @error($data[0]) is-invalid @enderror"
                id="sch" name="{{$data[0]}}" placeholder="Enter Store Name">
            @error($data[0])
                <span class="invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
      