@extends('app2') <!-- Assuming you have a layout -->

@section('content')
<div class="container-md d-flex align-items-start justify-content-center my-4">
    <div class="card p-4 col-xl-6 col-lg-8 col-md-10">
        <table id="table" class="table text-center caption-top overflow-y-scroll vh-75">
            <caption>Cập nhật đầy đủ các chu kỳ rớt trứng gần đây giúp cho việc dự báo được chính xác hơn</caption>
            <thead>
                <tr>
                    <th>Bắt đầu</th>
                    <th>Kết thúc</th>
                    <td class="col-3"><button class="btn btn-secondary btn-sm add_button"><i class="bi bi-plus-lg"></i></button></td>
                </tr>
            </thead>

            <tbody class="table-group-divider">
                <tr class="add_cycle table-warning">
                    <form action="{{ route('cycle.add') }}" method="POST" onsubmit="return confirm('Thêm chu kỳ?');">
                        @csrf
                        @method('POST')
                        <td><input type="date" class="form-control text-center"
                            name="cycle_start" required max="{{ today() }}"></td>
                        <td><input type="date" class="form-control text-center" 
                            name="period_stop" required></td>
                        <td class="col-3">
                            <button type="submit" class="btn btn-success btn-sm save_button">
                                <i class="bi bi-check-lg"></i></button>
                            <button type="button" class="btn btn-danger btn-sm cancel_button">
                                <i class="bi bi-x-lg"></i></button>
                        </td>
                    </form>
                </tr>
            
            @foreach ($cycles as $cycle)
                <tr class="show_cycle">
                    <form method="POST" action="{{ route('cycle.delete', $cycle->id) }}" onsubmit="return confirm('Xóa chu kỳ?');">
                        @csrf
                        @method('DELETE')
                        <td class="col-auto">{{ $cycle->cycle_start }}</td>
                        <td class="col-auto">{{ $cycle->period_stop }}</td>
                        <td class="col-3">
                                <button type="button" class="btn btn-primary btn-sm edit_button">
                                    <i class="bi bi-pencil"></i></button>
                                <button type="submit" class="btn btn-dark btn-sm delete_button" >
                                    <i class="bi bi-trash"></i></button>
                        </td>
                    </form>
                </tr>

                <tr class="edit_cycle table-info">
                    <form action="{{ route('cycle.update', $cycle->id) }}" method="POST" onsubmit="return confirm('Cập nhật chu kỳ?');">
                        @csrf
                        @method('PUT')
                        <td><input type="date" class="form-control text-center"
                            name="cycle_start" value="{{ $cycle->cycle_start }}" required max="{{ today() }}"></td>
                        <td><input type="date" class="form-control text-center" 
                            name="period_stop" value="{{ $cycle->period_stop }}" required max="{{ today() }}"></td>
                        <td class="col-3">
                            <button type="submit" class="btn btn-success btn-sm save_button">
                                <i class="bi bi-check-lg"></i></button>
                            <button type="button" class="btn btn-danger btn-sm cancel_button">
                                <i class="bi bi-x-lg"></i></button>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("tr:odd").hide();
        $(".add_button").click(function () { 
            $(".add_cycle").show();
            $(".add_button").hide();
            $(".edit_button").hide();
            $(".delete_button").hide();
        });

        $(".edit_button").click(function () { 
            $(this).parents("tr").hide();
            $(this).parents("tr").next().show();
            $(".add_button").hide();
            $(".edit_button").hide();
            $(".delete_button").hide();
        });

        $(".cancel_button").click(function () { 
            $(this).parents("tr").hide();
            $(this).parents("tr").prev().show();
            $(".add_button").show();
            $(".edit_button").show();
            $(".delete_button").show();
        });
    });
</script>
@endsection
