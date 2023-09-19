<div class="form-group col-md-6" id='ckbx'>
    <div class="form-check form-group">
        <div style="display: flex; justify-content:flex-start;align-items:flex-end;padding-left:5%;">
            <input class="form-control form-check-input  @error($data[0]) is-invalid @enderror" style="width: 2em;"
                type="checkbox" value="true" name='{{ $data[0] }}' id="{{ $data[0] }}"
                @if (isset($data[2])) @if (old($data[0], $data[2]) == 'true')
                    checked @endif
            @else @if (old($data[0]) == 'true') checked @endif @endif
            >
            <label class="form-check-label" style="font-size: 1.5em;" for="{{ $data[0] }}">
                {{ $data[1] }}
            </label>
        </div>

    </div>
    @error($data[0])
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>
