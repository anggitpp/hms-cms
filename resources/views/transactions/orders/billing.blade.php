<div class="printPdf">
    <div style="height: 25%">
    <table class="center">
        <tr>
            <td>
                <img src="{{ public_path('/storage/uploads/images/logo.png') }}" height="50">
            </td>
            <td>&nbsp;&nbsp;</td>
            <td>
                <h1>Hotel Indonesia</h1>
            </td>
        </tr>
    </table>
    <h2 style="float: right">Guest Folio</h2>
    <br>
    <br>
    <table style="width: 100%; font-size: 10;">
        <tr>
            <td style="width: 35%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 40%">Name</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Company</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->company_name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Address</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Nationality</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->nationality_id ? $masters['PAN'][$order->nationality_id] : 'Indonesia' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">ZIP</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->postal_code }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%">&nbsp;</td>
            <td style="width: 35%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 40%">Arrival Date</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ setDate($order->arrival_date, 't') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Departure Date</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ setDate($order->departure_date, 't') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Folio Number</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->folio_number }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Room Number</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->roomNumbers }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Room Rate</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">Rp. {{ setCurrency($order->price) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Room Type</td>
                        <td style="width: 10%">:</td>
                        <td style="width: 50%">{{ $order->roomTypes }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
    <br>
    <br>
    <hr>
    <div style="height: 35%">
    <table style="width: 100%; font-size: 10;">
        <tr style="borde-bottom: 1;">
            <th style="text-align: left" width="8%">Date</th>
            <th style="text-align: left" width="15%">Transaction</th>
            <th style="text-align: left" width="20%">Remark</th>
            <th style="text-align: left" width="8%">&nbsp;</th>
            <th style="text-align: right" width="10%">Debit</th>
            <th style="text-align: right" width="10%">Credit</th>
        </tr>
        @foreach($listOrders as $key => $lists)
            @foreach($lists as $k => $r)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $r['transaction'] ?? '' }}</td>
                    <td>{{ $r['remark'] ?? '' }}</td>
                    <td align="right">{{ $r['number'] ?? '' }}</td>
                    <td align="right">{{ $r['debit'] ? 'Rp. '.setCurrency($r['debit']) : '' }}</td>
                    <td align="right">{{ $r['credit'] ? 'Rp. '.setCurrency($r['credit']) : '' }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>
    </div>
    <div style="height: 20%">
        <hr>
        <table style="width: 100%; font-size: 10">
            <tr>
                <td style="width: 60%;text-align: left">Page 1 of 1</td>
                <td style="width: 20%;text-align: left">Balance</td>
                <td style="width: 15%;text-align: right; border-bottom: 1pt solid black;"><b>Rp. {{ setCurrency($order->fix_price) }}</b></td>
            </tr>
            <tr>
                <td style="height: 100px;vertical-align: bottom">
                    Print Date : {{ date('d F Y H:i:s') }}
                </td>
                <td style="vertical-align: bottom">Signature</td>
                <td style="text-align: right; border-bottom: 1pt solid black;"></td>
            </tr>
        </table>
        <div style="position: absolute; bottom: 1; font-size: 10">
            <center>{{ $hotel->address }}</center>
        </div>
    </div>
</div>
<style>
    @page { size: f4; }
    .center {
        margin-left: auto;
        margin-right: auto;
    }
</style>