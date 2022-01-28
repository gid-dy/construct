<html>
    <body>
        <table width='700px'>
            <tr>
                <td>Dear {{ $SurName }}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><h4>MS<span style="color: #fafd44;">WORLD</span></h4></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Hello {{ $SurName }} {{ $OtherNames }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thank you for booking a tour with us. Your booking details are as below :-</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Booking No: {{ $Booking_id }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table width='95%' cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                        <tr bgcolor="#CCCCCC">
                            <td>Service Name</td>
                            <td>ServiceType</td>
                            <td>Quantity</td>
                            <td> Price</td>
                        </tr>
                        @foreach($servicesDetails['bookings'] as $servepackage)
                            <tr>
                                <td>{{ $servepackage['ServiceName'] }}</td>
                                <td>{{ $servepackage['ServiceType'] }}</td>
                                <td>{{ $servepackage['Quantity'] }}</td>
                                <td>{{ $servepackage['ServicePrice'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right">Coupon Discount</td>
                            <td>GHS {{ $servicesDetails['Amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Grand Total</td>
                            <td>GHS {{ $servicesDetails['Grand_total'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td><strong>Billing Address:-</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['SurName'] }} {{ $userDetails['OtherNames'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['City'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['Mobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['OtherContact'] }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td><strong>Renting Address:-</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ $servicesDetails['SurName'] }} {{ $servicesDetails['OtherNames'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $servicesDetails['City'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $servicesDetails['Mobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $servicesDetails['OtherContact'] }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>For any enquiries, you can contact us at <a href="mailto:info@ghanatrek.com">info@ghanatrek.com</a></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Regards,<br> Team MS World</td></tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </body>
</html>
