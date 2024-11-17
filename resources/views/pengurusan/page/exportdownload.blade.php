<table>
    <thead>
        <tr>
            <th>Statistik Pengunjung Mengikut Tahun</th>
        </tr>
        <tr>
            <th>Tahun</th>
            <th>Bilangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{'2020'}}</td>
            <td>{{$visitor->visitor_count_2020}}</td>
        </tr>
        <tr>
            <td>{{'2021'}}</td>
            <td>{{$visitor->visitor_count_2021}}</td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Statistik Pengunjung Mengikut Bulan bagi Tahun {{ date('Y') }}</th>
        </tr>
        <tr>
            <th>Bulan</th>
            <th>Bilangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{'Januari'}}</td>
            <td>{{$visitor->visitor_count_month_1}}</td>
        </tr>
        <tr>
            <td>{{'Februari'}}</td>
            <td>{{$visitor->visitor_count_month_2}}</td>
        </tr>
        <tr>
            <td>{{'Mac'}}</td>
            <td>{{$visitor->visitor_count_month_3}}</td>
        </tr>
        <tr>
            <td>{{'April'}}</td>
            <td>{{$visitor->visitor_count_month_4}}</td>
        </tr>
        <tr>
            <td>{{'Mei'}}</td>
            <td>{{$visitor->visitor_count_month_5}}</td>
        </tr>
        <tr>
            <td>{{'Jun'}}</td>
            <td>{{$visitor->visitor_count_month_6}}</td>
        </tr>
        <tr>
            <td>{{'Julai'}}</td>
            <td>{{$visitor->visitor_count_month_7}}</td>
        </tr>
        <tr>
            <td>{{'Ogos'}}</td>
            <td>{{$visitor->visitor_count_month_8}}</td>
        </tr>
        <tr>
            <td>{{'September'}}</td>
            <td>{{$visitor->visitor_count_month_9}}</td>
        </tr>
        <tr>
            <td>{{'Oktober'}}</td>
            <td>{{$visitor->visitor_count_month_10}}</td>
        </tr>
        <tr>
            <td>{{'November'}}</td>
            <td>{{$visitor->visitor_count_month_11}}</td>
        </tr>
        <tr>
            <td>{{'Disember'}}</td>
            <td>{{$visitor->visitor_count_month_12}}</td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Statistik Pengunjung Mengikut 7 Hari Lalu</th>
        </tr>
        <tr>
            <th>Tarikh</th>
            <th>Bilangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{date('d-m-Y')}}</td>
            <td>{{$visitor->visitor_count_day}}</td>
        </tr>
        <tr>
            <td>{{date('d-m-Y',strtotime("-1 day"))}}</td>
            <td>{{$visitor->visitor_count_day_1}}</td>
        </tr>
        <tr>
            <td>{{date('d-m-Y',strtotime("-2 day"))}}</td>
            <td>{{$visitor->visitor_count_day_2}}</td>
        </tr>
        <tr>
            <td>{{date('d-m-Y',strtotime("-3 day"))}}</td>
            <td>{{$visitor->visitor_count_day_3}}</td>
        </tr>
        <tr>
            <td>{{date('d-m-Y',strtotime("-4 day"))}}</td>
            <td>{{$visitor->visitor_count_day_4}}</td>
        </tr>
        <tr>
            <td>{{date('d-m-Y',strtotime("-5 day"))}}</td>
            <td>{{$visitor->visitor_count_day_5}}</td>
        </tr>
        <tr>
            <td>{{date('d-m-Y',strtotime("-6 day"))}}</td>
            <td>{{$visitor->visitor_count_day_6}}</td>
        </tr>

    </tbody>
</table>
