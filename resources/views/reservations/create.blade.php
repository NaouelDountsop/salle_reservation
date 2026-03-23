@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('reservations.store') }}">
    @csrf

    <select name="room_id">
        @foreach($rooms as $room)
            <option value="{{ $room->id }}">{{ $room->name }}</option>
        @endforeach
    </select>

    <input type="datetime-local" name="start_time">
    <input type="datetime-local" name="end_time">

    <button type="submit">Réserver</button>
</form>