<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="pid">父级</label>
            <select class="form-control" id="pid" name="pid">
                <option value="0" @if(empty($pid)) selected="selected" @endif>顶级</option>
                @foreach($topChannels as $channel)
                    <option value="{{$channel['id']}}" @if(isset($pid) && $pid == $channel['id']) selected="selected" @endif>{{$channel['title']}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">渠道名称</label>
            <input type="text" class="form-control" name="title" placeholder="请输入渠道名称" value="{{$title or null}}">
        </div>

        <!-- 点击添加时无$pid或者编辑顶级时$pid==0,此时不显示此下拉框 -->
        <div class="form-group @if( !isset($pid) || (isset($pid) && ($pid==0)) ) hide @endif">
            <label for="pay_type">支付类型<small>(通道)</small></label>
            <select class="form-control" id="pay_type" name="pay_type">
                @foreach($payTypes as $type)
                    <option value="{{$type['pay_type']}}" @if(isset($pay_type) && $pay_type == $type['pay_type']) selected="selected" @endif>{{$type['name']}}</option>
                @endforeach
            </select>
        </div>

        <!-- 编辑子菜单时$pid存在且大于0,此时不显示此文本框 -->
        <div class="form-group @if(isset($pid) && $pid>0) hide @endif">
            <label for="name">服务名<small>(开发者填写)</small></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="请输入服务名称" value="{{$name or null}}">
        </div>

        <div class="form-group">
            <label for="sort">排序<small>(顶级DESC,子级ASC)</small></label>
            <input type="text" class="form-control" name="sort" placeholder="请输入序号" value="{{$sort or $maxSort}}">
        </div>

        <div class="form-group">
            <label for="status">状态</label>
            <input type="text" class="form-control" name="status" placeholder="请输入状态" value="{{$status or null}}">
        </div>
    </div>
    <!-- /.card-body -->
</form>