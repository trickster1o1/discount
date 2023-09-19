<div class="form-group col-md-6">
    <label for="slug">Slug*</label>

    <div class="input-group mb-3">
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
            placeholder="example: burger-house"
            @if (isset($data)) value="{{ old('slug', $data) }}"
            @else 
                value="{{ old('slug') }}" 
                @endif
                >
        <button class="btn btn-primary" type="button" id="generate-slug">Generate Slug</button>
        @error('slug')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>

</div>
