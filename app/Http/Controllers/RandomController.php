<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class RandomController extends Controller
{
    public function show(){
        $client = new Party([
            'name'          => 'Dhinesh DK',
            'phone'         => '7871759569',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Party([
            'name'          => 'Dhanashekaran',
            'address'       => 'Selam',
            'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '#00001',
            ],
        ]);

        $items = [
            (new InvoiceItem())->title('Audi R8 V10')->pricePerUnit(142700)->quantity(1)->discount(10),
            // (new InvoiceItem())->title('Service 2')->pricePerUnit(71.96)->quantity(2),
            // (new InvoiceItem())->title('Service 3')->pricePerUnit(4.56),
            // (new InvoiceItem())->title('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4)->units('kg'),
            // (new InvoiceItem())->title('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
            // (new InvoiceItem())->title('Service 6')->pricePerUnit(76.32)->quantity(9),
            // (new InvoiceItem())->title('Service 7')->pricePerUnit(58.18)->quantity(3)->discount(3),
            // (new InvoiceItem())->title('Service 8')->pricePerUnit(42.99)->quantity(4)->discountByPercent(3),
            // (new InvoiceItem())->title('Service 9')->pricePerUnit(33.24)->quantity(6)->units('m2'),
            // (new InvoiceItem())->title('Service 11')->pricePerUnit(97.45)->quantity(2),
            // (new InvoiceItem())->title('Service 12')->pricePerUnit(92.82),
            // (new InvoiceItem())->title('Service 13')->pricePerUnit(12.98),
            // (new InvoiceItem())->title('Service 14')->pricePerUnit(160)->units('hours'),
            // (new InvoiceItem())->title('Service 15')->pricePerUnit(62.21)->discountByPercent(5),
            // (new InvoiceItem())->title('Service 16')->pricePerUnit(2.80),
            // (new InvoiceItem())->title('Service 17')->pricePerUnit(56.21),
            // (new InvoiceItem())->title('Service 18')->pricePerUnit(66.81)->discountByPercent(8),
            // (new InvoiceItem())->title('Service 19')->pricePerUnit(76.37),
            // (new InvoiceItem())->title('Service 20')->pricePerUnit(55.80),
        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('INVOICE')
            ->series('DMS')
            ->sequence(001)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(0))
            ->dateFormat('d/m/Y')
            ->payUntilDays(14)
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            // ->notes($notes)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link
        // dd($link);

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }
}
