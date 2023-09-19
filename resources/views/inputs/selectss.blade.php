<div class="form-group col-md-6">
    <label for="{{$data[0]}}">{{$data['1']}}</label>
    <select class="form-control form-select @error($data[0]) is-invalid @enderror" aria-label="Default select example" name="{{$data[0]}}" id="{{$data[0]}}">                                            
        <option value="">- Select -</option>
        @foreach ($option as $opt)
            <option value="{{$opt['id']}}" @if(strtolower(old($data[0], $default)) == $opt['id']) selected @endif >{{$opt['name']}}</option>
        @endforeach
      </select>
    @error($data[0])
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>