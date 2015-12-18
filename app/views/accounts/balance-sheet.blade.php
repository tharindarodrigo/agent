<table class="table table-striped" border="1px">
    <thead>
    <tr bgcolor="#a9a9a9" style="color:#FFFFFF">
        <th align="center">ID</th>
        <th align="center">Date</th>
        <th align="center">Detail</th>
        <th align="center">Credit</th>
        <th align="center">Debit</th>
        <th align="center">Balance</th>
    </tr>
    </thead>
    <tbody>

    @if(!empty($merged_data))
        @for($x= 0; $x< count($merged_data); $x++)
            <tr>
                <td>{{$y=$x+1}}</td>
                <td>{{date('Y-m-d',strtotime($merged_data[$x]['date']))}}</td>
                <td>{{$merged_data[$x]['details']}}</td>
                <td align="right">{{!empty($merged_data[$x]['credit']) ?  number_format($merged_data[$x]['credit'],2) : '-'}}</td>
                <td align="right">{{!empty($merged_data[$x]['debit']) ? number_format($merged_data[$x]['debit'],2) : '-'}}</td>

                <td align="right">
                    <?php
                    $crdt = ($x == 0) ? Agent::getCreditLimit(Auth::id()) : 0;
                    if (!empty($merged_data[$x]['credit']))
                        $c = $merged_data[$x]['credit'];
                    elseif (!empty($merged_data[$x]['debit']))
                        $c = -$merged_data[$x]['debit'];
                    ?>
                    {{number_format($total += $crdt - $c,2)}}
                </td>
            </tr>

        @endfor
    @endif

    </tbody>
</table>
