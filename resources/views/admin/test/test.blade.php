@extends('admin_template')
@section('content')
    <div class='row'>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Progress bars</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @foreach($tasks as $task)
                        <h5>
                            {{ $task['name'] }}
                            <small class="label label-{{$task['color']}} pull-right">{{$task['progress']}}%</small>
                        </h5>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-{{$task['color']}} progress" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                 aria-valuemax="100" style="width: {{$task['progress']}}%">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div><!-- /.row -->
@endsection