<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>

    <div class="col-sm-6">

        @include('admin::form.error')

        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-mobile"></i>
            </div>
            <input type="text" id="{{$id}}" name="{{$name}}" value="{{ Input::old($column, $value) }}" class="form-control" data-inputmask='"mask": "+86 19999999999"' data-mask placeholder="输入{{$label}}">
        </div>
    </div>
</div>