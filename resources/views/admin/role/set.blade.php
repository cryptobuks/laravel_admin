@extends('admin_template')
@section('content')
    <style>
        .dd1 {
            background: #ECECEC;
        }
        dl dd {
            height: 30px;
            line-height: 30px;
            padding-left: 20px;
            color: #666;
        }
        dd {
            margin-left: 0;
        }
        .table-responsive {
            min-height: .01%;
            overflow-x: auto;
        }
    </style>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages">
                            <dl>
                                <dd class="dd1">
                                    <label>
                                        <input type="checkbox" class="index_perm" name="ids" value="{{$index_perm->id}}"
                                               @if($index_perm->value == 1)checked @endif >
                                        后台首页
                                    </label>
                                </dd>

                                @foreach($perms as $group => $sub_perms)
                                    <dd class="dd1">
                                        <label><input type="checkbox" class="parent-{{$group}}" name="ids" value="0"
                                                      @if($group_values[$group] == 1)
                                                      checked
                                                    @endif
                                            > {{admin_group_tag($group)}}</label>
                                    </dd>
                                    @foreach($sub_perms as $perm)
                                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox" class="children-{{$group}}" name="ids" value="{{$perm->id}}"
                                                          @if($perm->value==1)
                                                          checked
                                                        @endif
                                                >{{$perm->desc}}</label>
                                        </dd>
                                    @endforeach
                                @endforeach
                            </dl>
                        </div>
                        <!-- /<div class="mail-box-message"></div>s -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer with-border">
                        <div class="pull-left" style="margin-left:10px;">
                            <button type="button" class="btn btn-block btn-default btn-sm btn-save">提交</button>
                        </div>
                        <div class="pull-right">
                        </div>
                        <!-- /.box-tools -->
                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var groups = '{!!$groups!!}';
            var groups = JSON.parse(groups);
            //groups.each(function(group){
            $.each(groups,function(index,group){
                $(".parent-"+group).click(function(){
                    if(this.checked){
                        $(".children-"+group).each(function(){this.checked=true;});
                    }else{
                        $(".children-"+group).each(function(){this.checked=false;});
                    }
                });
                $(".children-"+group).click(function(){
                    if(this.checked==true){
                        var check_all = true;
                        $(".children-"+group).each(function(){
                            if(this.checked==false){
                                check_all = false;
                            }
                        });
                        //var is_all = $(".children-"+group).is(":checked");
                        if(check_all){
                            $(".parent-adv").prop("checked",true);
                        }
                    }else{
                        if($(".parent-adv").is(":checked")){
                            $(".parent-adv").prop("checked",false);
                        }
                    }
                })
            });

            $(".btn-save").click(function () {
                var ids_array = Array();
                $("input[name='ids']").each(function(){
                    if(this.checked && this.value>0){
                        ids_array.push(this.value);
                    }
                });
                if(ids_array.length == 0){
                    alert('请选择待添加的权限!');
                }

                var perm_ids = ids_array.join(',');
                var data = {'perm_ids':perm_ids}
                var url = '/admin/role/authperms/id/'+'{{$role->id}}'
                $.post(url,data,function(json){
                    if(json.status == 0){
                        swal({
                            title:'操作成功',
                            type:'success',
                            showLoaderOnConfirm: true,
                            preConfirm: function(email) {
                                return new Promise(function(resolve) {
                                    location.reload();
                                });
                            },
                        });

                    }else{
                        alert(json.message);
                    }
                },'json')
            });
        })
    </script>
@stop