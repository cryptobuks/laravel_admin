<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="pid">父菜单</label>
            <select class="form-control" id="pid" name="pid">
                <option value="0" @if(empty($pid)) selected="selected" @endif>顶级菜单</option>
                @foreach($top_menus as $menu)
                    <option value="{{$menu->id}}" @if(isset($pid) && $pid == $menu->id) selected="selected" @endif>{{$menu->name}}</option>
                @endforeach
            </select>
        </div>

        <!-- 点击添加时无$pid或者编辑顶级菜单时$pid==0,此时不显示此下拉框 -->
        <div class="form-group @if( !isset($pid) || (isset($pid) && ($pid==0)) ) hide @endif">
            <label for="permission_id">子菜单URI</label>
            <select class="form-control" id="permission_id" name="permission_id">
                @foreach($permissions as $permission)
                    <option value="{{$permission->id}}" @if(isset($permission_id) && $permission_id == $permission->id) selected="selected" @endif>{{$permission->description}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name">菜单名称</label>
            <input type="text" class="form-control" name="name" placeholder="请输入菜单名称" value="{{$name or null}}">
        </div>

        <!-- 编辑子菜单时$pid存在且大于0,此时不显示此下拉框 -->
        <div class="form-group @if(isset($pid) && $pid>0) hide @endif">
            <label for="group">分组</label>
            <input type="text" class="form-control" id="group" name="group" placeholder="请输入分组标志" value="{{$group or null}}">
        </div>

        <div class="form-group">
            <label for="sort">排序</label>
            <input type="text" class="form-control" name="sort" placeholder="请输入序号-ASC" value="{{$sort or null}}">
        </div>
    </div>
    <!-- /.card-body -->
</form>