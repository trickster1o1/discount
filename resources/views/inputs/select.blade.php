<div class="form-group col-md-6">
    <label for="{{ $data[0] }}">{{ $data['1'] }}</label>
    <select class="form-control form-select  @error($data[0]) is-invalid @enderror" aria-label="Default select example"
        name="{{ $data[0] }}" id="{{ $data[0] }}">
        @php
            $i = 0;
        @endphp
        @foreach ($option as $opt)
            <option
                @if (isset($value)) value="{{ $value[$i] }}"
                @php
                    $i+=1;
                @endphp @endif
                @if (isset($default)) @if (old($data[0], $default) == $opt)
                    selected @endif
            @else @if (old($data[0]) == $opt) selected @endif @endif >{{ $opt }}
            </option>
        @endforeach
    </select>
    @error($data[0])
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>
