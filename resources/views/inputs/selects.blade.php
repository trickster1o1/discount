<div class="form-group col-md-6">
    <label for="{{$data[0]}}">{{$data['1']}}</label>
    <select class="form-control form-select @error($data[0]) is-invalid @enderror" aria-label="Default select example" name="{{$data[0]}}" id="{{$data[0]}}">                                            
        {{-- <option value="fixed">Fixed</option>
        <option value="percent" selected>Percent(%)</option> --}}
        @foreach ($option as $opt)
            <option value="{{strtolower($opt)}}" @if(strtolower(old($data[0], $default)) == strtolower($opt)) selected @endif >{{$opt}}</option>
        @endforeach
      </select>
    @error($data[0])
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>