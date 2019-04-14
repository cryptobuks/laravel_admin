<form role="form">
    <div class="card-body">
        <div class="form-group">
            <label for="name">通道名称</label>
            <input type="text" class="form-control" name="name" placeholder="请输入通道名称" autofocus>
        </div>
        <div class="form-group">
            <label for="pay_type">支付类型</label>
            <input type="text" class="form-control" name="pay_type" placeholder="请输入支付类型">
        </div>
        <div class="form-group">
            <label for="rate">交易费率(百分比%)</label>
            <input type="text" class="form-control" name="rate" placeholder="请输入交易费率(小数)">
        </div>
        <div class="form-group">
            <label for="min">单笔最小额度</label>
            <input type="text" class="form-control" name="min" placeholder="请输入最小额度">
        </div>
        <div class="form-group">
            <label for="max">单笔最大额度</label>
            <input type="text" class="form-control" name="max" placeholder="请输入最大额度">
        </div>
        <div class="form-group">
            <label for="limit">当日交易限额</label>
            <input type="text" class="form-control" name="limit" placeholder="请输入限制额度">
        </div>
        <div class="form-group">
            <label for="settle_type">结算方式</label>
            <input type="text" class="form-control" name="settle_type" placeholder="请输入结算方式">
        </div>
        <div class="form-group">
            <label for="status">通道状态</label>
            <input type="text" class="form-control" name="status" placeholder="请输入通道状态">
        </div>
    </div>
    <!-- /.card-body -->
</form>