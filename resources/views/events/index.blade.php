@extends('layouts.header')
@section('content')
<main class="container">
    <h1>Events List</h1>
    <table style="width:100%; border-collapse:collapse; margin-top:2rem;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Organizer</th>
                <th>Category</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Location</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->organizer->first_name ?? '' }} {{ $event->organizer->last_name ?? '' }}</td>
                <td>{{ $event->category->name ?? '' }}</td>
                <td>{{ $event->start_date }}</td>
                <td>{{ $event->end_date }}</td>
                <td>{{ $event->location }}</td>
                <td>{{ $event->price == 0 ? 'Free' : '$' . number_format($event->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>
@include('layouts.footer')
@endsection 