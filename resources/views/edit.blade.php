@extends('app2') <!-- Assuming you have a layout -->

@section('content')
<div class="container-md d-flex align-items-start justify-content-lg-around justify-content-md-start my-4">
    <table id="table" class="col-xl-6 col-lg-8 col-md-10 table table-hover text-center">
        <caption>Hướng dẫn</caption>
        <thead>
            <tr>
                <th>Cycle Start</th>
                <th>Period Stop</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        @foreach ($cycles as $cycle)
            <tr>
                <td>{{ $cycle->cycle_start }}</td>
                <td>{{ $cycle->period_stop }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script src="{{ asset('seraphnet-bootstable/bootstable.js') }}"></script>
<script>
    const bstable = new bootstable("table", {
        $addButton: "add",
        customInputs: [
            type="date"
        ],
    });
</script>
@endsection
