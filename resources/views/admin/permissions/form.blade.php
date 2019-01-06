@if ($errors->any())
  <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
          {{ $error }}<br>        
      @endforeach
  </div>
@endif

<div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-4">Create Permission</div>
                </div>
            </div>
            <div class="panel-body">

                <div class="name col-md-4">
                    <div class="form-group">
                        <label for="name">{{ trans('form.name') }}</label>
                        <div class="check_name">
                             {!! Form::text('name', null , [
                                'class' => 'form-control',
                                'id' => 'name',
                                'required' => 'required'
                             ]) !!}
                        </div>
                    </div>
                </div>

                <div class="slug col-md-4">
                    <div class="form-group">
                        <label for="slug">{{ trans('form.slug') }}</label>
                        <div class="check_slug">
                             {!! Form::text('slug', null , [
                                'class' => 'form-control',
                                'id' => 'slug',
                                'required' => 'required'
                             ]) !!}
                        </div>
                    </div>
                </div>


                <div class="description col-md-4">
                    <div class="form-group">
                        <label for="description">{{ trans('form.description') }}</label>
                        <div class="check_description">
                             {!! Form::text('description', null , [
                                'class' => 'form-control',
                                'id' => 'description',
                                'required' => 'required'
                             ]) !!}
                        </div>
                    </div>
                </div>

                


            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-key"></i>Create</button>
                    </div>
                </div>
            </div>
        </div>