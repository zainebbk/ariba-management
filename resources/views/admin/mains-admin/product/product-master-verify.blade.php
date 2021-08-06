<div class="tab_content">
    <label class="col-md-4 form-label">Product images : </label>
    <div class="row row-sm mt-4">
        @foreach ($data['images'] as $image)
            <img src="https://ariba.ma/image/{{ $image->image }}" id="image"
            alt="image" class="card-image1 " style="max-width: 30%;">
        @endforeach
    </div>
</div>