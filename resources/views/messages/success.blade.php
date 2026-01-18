@if (session('message'))

<div 
  class="alert alert-success alert-dismissible shadow position-absolute top-0 end-0 m-4 message" 
  style="display: none;" 
  role="alert"
>
  <div>
    <h4>{{ session('message') }}</h4>
  
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>

@endif
