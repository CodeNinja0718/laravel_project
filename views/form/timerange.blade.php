<div class="form-group {!! ($errors->has($errorKey['start'].'start') || $errors->has($errorKey['end'].'end')) ? 'has-error' : ''  !!}">

    <label for="{{$id['start']}}" class="col-sm-2 col-lg-2 control-label">{{$label}}</label>

    <div class="col-sm-10 col-lg-8">

        @include('admin::form.error')

        <div class="row" style="width: 370px">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="{{$name['start']}}" value="{{ old($column['start'], $value['start']) }}" class="form-control {{$class['start']}}" style="width: 150px" {!! $attributes !!} />
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="{{$name['end']}}" value="{{ old($column['end'], $value['end']) }}" class="form-control {{$class['end']}}" style="width: 150px" {!! $attributes !!} />
                </div>
            </div>
        </div>

        @include('admin::form.help-block')

    </div>
</div>
