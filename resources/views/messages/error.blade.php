@if ($errors->any())

<div 
  class="alert alert-danger alert-dismissible shadow position-absolute top-0 end-0 m-4 message" 
  style="display: none;" 
  role="alert"
>
  <div>
    <h4>Ошибка!</h4>
  
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  
    @foreach($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
</div>

@endif
