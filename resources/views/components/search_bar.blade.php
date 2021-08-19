<form action="{{ action($action)}}">
    <div class="form-group">
        <input type="text" name="keyword" class="form-control search-input" placeholder="Search" value="{{ request('keyword') ? request('keyword') : '' }}">
        <button type="submit" class="btn btn-block btn-warning btn-sm submit-input">{{ $button }}</button>
    </div>
</form>