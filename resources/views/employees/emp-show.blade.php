<table>
    <tr>
        <td>
            <h4>Employee Attendance</h4>
        </td>
        
    </tr>
    <tr>
        <td>
            Date
        </td>
        <td>
            Comment
        </td>
        <td>
            Working Hour
        </td>
    </tr>
    @if(isset($diff))
    @foreach($diff as $item)
    <tr>
        <td>
            {{$item['date']}}
        </td>
        <td>
            {{$item['comment']}}
        </td>
        <td>
            {{$item['diff']}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td>
            Total hr:{{$data['total_hr']}}
        </td>
    </tr>
    @else
    <tr>
        <td>
            No Data Found
        </td>
    </tr>
    @endif
</table>