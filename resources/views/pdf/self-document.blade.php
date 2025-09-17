<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
        }

        table,
        tr,
        td,
        th {
            border-collapse: collapse;
            font-size: 16px;
            padding: 15px;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    @php
        use App\Models\SelfModule\Appointments;
    @endphp
    <table>
        <tr>
            <td style="padding: 0;">
                <table style="padding:35px 0;">
                    <tr>
                        <td><img src="{{ asset('assets/img/web/logo.png') }}"></td>
                        <td style="text-align: right;"><img src="{{ asset('assets/img/web/humsafar-logo.png') }}"
                                style="width: 125px"></td>
                    </tr>
                </table>
                <table style="background: #146f98;color:#fff">
                    <tr>
                        <td></td>
                        <td
                            style="background: #fff;width: 165px;color: #146f98;font-size: 33px;text-transform: uppercase;text-align: center;font-weight: 600;">
                            E-Referral Slip</td>
                        <td style="width: 50px;"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="line-height: 24px;"><strong>Client
                                Name</strong><br>{{ $pdfData[Appointments::full_name] }}</td>
                        <td style="text-align: right;"><strong>Date :</strong>
                            {{ $pdfData['today'] }}<br /><strong>Netreach UID
                                :</strong>{{ $pdfData[Appointments::uid] }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Service Provider Name/Address</th>
                        <th> {{ $pdfData['center'] }}</th>
                    </tr>
                    <tr>
                        <td>Appointment Date</td>
                        <td>{{ $pdfData[Appointments::appointment_date] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Type of Services selected </th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    @if(is_array($pdfData[Appointments::services]))
                                    @foreach ($pdfData[Appointments::services] as $item)
                                        <td
                                            style="padding:15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 10px;">
                                            {{ SERVICES[intval($item)] }}
                                        </td>
                                    @endforeach
                                    @else
                                    <td
                                            style="padding:15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 10px;">
                                            {{ $pdfData[Appointments::services] }}
                                        </td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        @isset($pdfData['vnname'])
                            <td>VN Name: {{ $pdfData['vnname'] }}</td>
                        @endisset
                        @isset($pdfData['vnmobile'])
                            <td>VN Mobile: {{ $pdfData['vnmobile'] }}</td>
                        @endisset
                        {{-- @isset($vnname)
                            <td>VN Name: {{ $vnname }}</td>
                        @endisset
                        @isset($vnmobile)
                            <td>VN Mobile: {{ $vnmobile }}</td>
                        @endisset --}}
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>E-Referral Slip No: {{ $pdfData[Appointments::referral_no] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
