<div class="col-md-12">
      <div class="scroll-container">
        @foreach($images as $image)
          <div class="img-container">
            <img src="{{ asset('storage/' . $image) }}" alt="Image" class="img-thumbnail">
          </div>
        @endforeach
      </div>
    </div>