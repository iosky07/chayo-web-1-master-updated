<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>invoice-{{strtolower($customer['name'])}}-{{str_replace(' ', '-', strtolower($formattedDate))}}</title>
    <link rel="stylesheet" href="invoice-assets-2/style.css" media="all" />

</head>
<body>
@isset($payment)
    <div class="invoice-ribbon"><div class="ribbon-inner">PAID</div></div>
@endisset

<header class="clearfix">
    <div id="logo">
        <img src="invoice-assets-2/main-logo.png">
    </div>
    <h1>invoice-{{strtolower($customer['name'])}}-{{str_replace(' ', '-', strtolower($formattedDate))}}</h1>

    <div id="company" class="clearfix">
        <div>TAGIHAN <span style="padding-left: 38px">:</span> 01 {{ $formattedDate }}</div>
        <div>JATUH TEMPO : 15 {{ $formattedDate }}</div>
    </div>
    <div style="font-size: 15px">
        <div>KEPADA <span style="padding-left: 12px">:</span> {{ $customer['name'] }}</div>
        <div>NO. HP <span style="padding-left: 22px">:</span> {{ $customer['phone_number'] }}</div>
        <div>ALAMAT <span style="padding-left: 14px">:</span> {{ $customer['address'] }}</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th><b>NO</b></th>
            <th><b>DESKRIPSI</b></th>
            <th><b>HARGA</b></th>
            <th><b>QTY</b></th>
            <th><b>TOTAL</b></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="qty">1</td>
            @isset($payment)
                <td class="desc">Tagihan Wifi bulan ({{ $payment['description'] }})</td>
                <td class="unit">Rp. {{ number_format($customer['bill'], 0, ',', '.') }}</td>
                <td class="qty">{{ $payment['nominal'] / $customer['bill'] }}</td>
                <td class="total">Rp. {{ number_format($payment['nominal'], 0, ',', '.') }}</td>
            </tr>
            {{--        <tr>--}}
            {{--            <td colspan="4">SUBTOTAL</td>--}}
            {{--            <td class="total">$5,200.00</td>--}}
            {{--        </tr>--}}
            {{--        <tr>--}}
            {{--            <td colspan="4">TAX 25%</td>--}}
            {{--            <td class="total">$1,300.00</td>--}}
            {{--        </tr>--}}
            <tr>
                <td colspan="4" class="grand total"><b>GRAND TOTAL</b></td>
                <td class="grand total"><b>Rp. {{ number_format($payment['nominal'], 0, ',', '.') }}</b></td>
            </tr>
            @endisset
            @isset($invoice)
                <td class="desc">Tagihan Wifi {{ $formattedDate }}</td>
                <td class="unit">Rp. {{ number_format($customer['bill'], 0, ',', '.') }}</td>
                <td class="qty">1</td>
                <td class="total">Rp. {{ number_format($customer['bill'], 0, ',', '.') }}</td>
                </tr>
                {{--        <tr>--}}
                {{--            <td colspan="4">SUBTOTAL</td>--}}
                {{--            <td class="total">$5,200.00</td>--}}
                {{--        </tr>--}}
                {{--        <tr>--}}
                {{--            <td colspan="4">TAX 25%</td>--}}
                {{--            <td class="total">$1,300.00</td>--}}
                {{--        </tr>--}}
                <tr>
                    <td colspan="4" class="grand total"><b>GRAND TOTAL</b></td>
                    <td class="grand total"><b>Rp. {{ number_format($customer['bill'], 0, ',', '.') }}</b></td>
                </tr>
            @endisset

        </tbody>
    </table>
    <br>
    <div id="company">
        <div><b>PT. Chayo Anugrah Teknologi</b></div>
        <div id="ttd">
            <img src="invoice-assets-2/ttd-nardi.jpg">
        </div>
        <div style="margin-right: 80px"><b>Nardi</b></div>
        <div style="margin-right: 35px">Bagian Keuangan</div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br>

    <div id="notices">
        <div><b>Silahkan transfer ke:</b></div>
        <ul>
            <li>Bank BCA a/n CHAYO ANUGRAH TEKNOLOGI, No. rek : 1470717854</li>
            <li>Bank BRI a/n PT. CHAYO ANUGRAH TEKNOLOGI, No. rek : 002101003850303</li>
            <li>Bank Mandiri a/n PT. CHAYO ANUGRAH TEKNOLOGI, No. rek : 1430025439991</li>
        </ul>
        <div><b>Perhatian:</b></div>
        <ul>
            <li>Pembayaran dianggap sah apabila dana sudah masuk ke rekening kami, dan bukti setor pembayaran telah kami terima.</li>
            <li>Untuk kelancaran pelayanan, harap membayar invoice tepat pada waktunya.</li>
            <li>Pembayaran yang melewati batas tempo yang telah ditentukan, akan dikenakan sanksi denda 2% dari total tagihan invoice yang belum terbayarkan.</li>
        </ul>
    </div>
    <br><br><br><br>
    <div id="company" class="clearfix">
        <div><b>PT. Chayo Anugrah Teknologi</b></div>
        <div>Jln. Hasanuddin, Dsn. Krajan B<br /> Kec. Kencong, Kab. Jember (68167)</div>
        <div>082332555886</div>
        <div><a href="mailto:info@chayo.web.id">info@chayo.web.id</a></div>
    </div>
</main>
{{--<img src="invoice-assets-2/footer-ornament.jpg" style="bottom: 0; left: 0;">--}}
</body>
</html>
