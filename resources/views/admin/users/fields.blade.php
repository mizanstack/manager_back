<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Role Id Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}<span class="required">*</span>
    {!! Form::select('role_key', \App\Role::pluck('name', 'key'), null, ['id'=>'role_key', 'class' => 'form-control', 'required', 'placeholder' => 'Pick a role...']) !!}
</div> --}}

@if(if_its_edit_route())
    <div class="form-group col-sm-6">
        {!! Form::label('role', 'Role:') !!}<span class="required">*</span>
        {!! Form::select('roles[]', $roles, $userRole, array('class' => 'form-control','multiple', 'id' => 'role_id')) !!}
    </div>
    
@else
    <div class="form-group col-sm-6">
        {!! Form::label('role', 'Role:') !!}<span class="required">*</span>
        {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple', 'id' => 'role_id')) !!}
    </div>
@endif




<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Path Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('image_path', 'Image Path:') !!}
    {!! Form::text('image_path', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
</div>
