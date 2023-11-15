<div class="row">
    @foreach($bloodGroups as $bloodGroup)
        <div class="col-md-1">
            <!-- radio -->
            <div class="form-group clearfix">
                <div class="icheck-primary d-inline">
                    <input {{ $attributes }} type="radio" value="{{$bloodGroup->name}}"
                           id="{{$bloodGroup->name}}">
                    <label for="{{$bloodGroup->name}}">
                        {{$bloodGroup->name}}
                    </label>
                </div>
            </div>
        </div>
    @endforeach
</div>
