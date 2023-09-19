<div class="clone increment hide">
    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
        <div class="form-group col-md-4">
            <!-- <label for="image_url">Image URL *</label> -->
            <div class="input-group md-3">
                <input type="text"
                    class="form-control @error('image_url') is-invalid @enderror"
                    id="image_url_{{$url_id}}" name="image_url[]" placeholder="Image URL*"
                    value="{{$data_image_url}}">
                <button class="btn btn-primary popup_selector" data-inputid="image_url_{{$url_id}}"
                    type="button">
                    Select Image
                </button>
            </div>
            @error('image_url[]')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <!-- <label for="title">Title</label> -->
            <input type="text"
                class="form-control @error('image_title[]') is-invalid @enderror"
                id="title" name="image_title[]" placeholder="Title"
                value="{{ $data_image_title }}">
            @error('image_title[]')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <!-- <label for="title">Title</label> -->
            <input type="text"
                class="form-control @error('video_url[]') is-invalid @enderror"
                id="video_url" name="video_url[]" placeholder="Video Url"
                value="{{ $data_video_url }}">
            @error('video_url[]')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <!-- <label for="description">Description</label> -->
            <textarea rows="1" class="form-control @error('description[]') is-invalid @enderror" id="description" name="description[]" placeholder="Descprition">{{ @$data_description }}</textarea>
            @error('description[]')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <div class="input-group md-3">
                <input type="number"  placeholder="Image Order" class="form-control" name="order_by[]" value="{{ $data_order_by }}">
                @if($url_id == 0)
                <button class="btn btn-success form_control" type="button" title="Add More Image"><i class="fa fa-plus"></i></button>
                @else
                <button class="btn btn-danger" type="button" title="Remove Image"> <i class="fa fa-trash"></i></button>
                @endif
            </div>
        </div>
    </div>
</div>