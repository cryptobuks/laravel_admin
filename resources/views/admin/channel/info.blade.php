<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="gateway">支付网关</label>
            <input type="text" class="form-control" name="gateway" placeholder="请输入支付网关" value="{{$gateway or null}}" autofocus>
        </div>

        <div class="form-group">
            <label for="merchant">商户号</label>
            <input type="text" class="form-control" name="merchant" placeholder="请输入商户号" value="{{$merchant or null}}" autofocus>
        </div>

        <div class="form-group">
            <label for="key">商户秘钥</label>
            <input type="text" class="form-control" name="key" placeholder="请输入商户秘钥" value="{{$key or null}}" autofocus>
        </div>
    </div>
    <!-- /.card-body -->
</form>