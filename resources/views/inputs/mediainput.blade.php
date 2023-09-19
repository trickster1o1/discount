<div @php
if (isset($md)) {
    echo 'class="form-group col-md-'.$md.'"';
} else {
    echo 'class="form-group col-md-6"';
}
@endphp>
    <label for="{{ $data[0] }}">{{ $data[1] }}</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control @error('{{ $data[0] }}') is-invalid @enderror"
            id="{{ $data[0] }}" name="{{ $data[0] }}" placeholder="{{ $data[2] }}"
            @if (isset($data[3])) value = {{ old($data[0], $data[3]) }}
        @else
            value = {{ old($data[0]) }} @endif>
        <button class="btn btn-primary popup_selector" data-inputid="{{ $data[0] }}" type="button">
            Select
        </button>
    </div>
    @error($data[0])
        <span class=" invalid-feedback"> {{ $message }} </span>
    @enderror
</div>
