<form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{$action}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">name</label>
        <input type="text" id="name" name="name" class="form-control" required="">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">price</label>
        <input type="text" id="price" name="price" class="form-control" required="">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">sku</label>
        <input type="text" id="sku" name="sku" class="form-control" required="">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">qty</label>
        <input type="text" id="qty" name="qty" class="form-control" required="">
    </div>
    <button type="submit" class="btn btn-primary">save</button>
</form>