@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert
                    alert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
            @if ($message['important'])
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
            @endif

            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}


{{-- @if(count($errors))
	<div class="admin-errors">
	    <strong>Whoops!</strong> There were some problems with your input.<br><br>
	     <ul class="alert alert-danger">
	         @foreach($errors->all() as $error)
	            <li>{{$error}}</li>
	          @endforeach
	     </ul>
	</div>
@endif --}}


@if(!empty($errors))
    @if($errors->any())
        <ul class="alert alert-danger" style="list-style-type: none">
            @foreach($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    @endif
@endif


@if(session()->has('message'))
	<div class="admin-errors">
	     <div class="alert alert-info">
            <p>{{session()->get('message')}}</p>
	     </div>
	</div><!--/ admin-errors -->
@endif

@if ($message = Session::get('success'))

<div class="admin-errors">
	<div class="alert alert-success">
    	<p>{{ $message }}</p>
 	</div>
</div><!--/ admin-errors -->

@endif


@if ($message = Session::get('error'))

<div class="admin-errors">
	<div class="alert alert-danger">
    	<p>{{ $message }}</p>
 	</div>
</div><!--/ admin-errors -->

@endif