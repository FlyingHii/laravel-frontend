<form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('checkout::cart.add', ['id' => $product->id])}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">qty</label>
        <input type="text" id="qty" name="qty" value="0" class="form-control" required="">
        <input type="text" id="qty" name="qty" value="0" class="form-control" required="">
        <input type="text" id="qty" name="qty" value="0" class="form-control" required="">
        <input type="text" id="qty" name="qty" value="0" class="form-control" required="">
    </div>
    <button type="submit" class="btn btn-primary">Add to cart</button>
</form>

<script>

</script>
