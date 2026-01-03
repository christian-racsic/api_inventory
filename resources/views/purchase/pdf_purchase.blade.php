<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Solicitud de Compra</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- <link rel="stylesheet" href="{{ asset('pdf/modern-normalize.css') }}"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('pdf/web-base.css') }}"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('pdf/invoice.css') }}"> --}}
    <style>
        *,
*::before,
*::after {
	box-sizing: border-box;
}

:root {
	-moz-tab-size: 4;
	tab-size: 4;
}

html {
	line-height: 1.15; 	-webkit-text-size-adjust: 100%; }

body {
	margin: 0;
}

body {
	font-family:
		system-ui,
		-apple-system, 		'Segoe UI',
		Roboto,
		Helvetica,
		Arial,
		sans-serif,
		'Apple Color Emoji',
		'Segoe UI Emoji';
}

hr {
	height: 0; 	color: inherit; }

abbr[title] {
	text-decoration: underline dotted;
}

b,
strong {
	font-weight: bolder;
}

code,
kbd,
samp,
pre {
	font-family:
		ui-monospace,
		SFMono-Regular,
		Consolas,
		'Liberation Mono',
		Menlo,
		monospace; 	font-size: 1em; }

small {
	font-size: 80%;
}

sub,
sup {
	font-size: 75%;
	line-height: 0;
	position: relative;
	vertical-align: baseline;
}

sub {
	bottom: -0.25em;
}

sup {
	top: -0.5em;
}

table {
	text-indent: 0; 	border-color: inherit; }

button,
input,
optgroup,
select,
textarea {
	font-family: inherit; 	font-size: 100%; 	line-height: 1.15; 	margin: 0; }

button,
select { 	text-transform: none;
}

button,
[type='button'],
[type='reset'],
[type='submit'] {
	-webkit-appearance: button;
}

::-moz-focus-inner {
	border-style: none;
	padding: 0;
}

:-moz-focusring {
	outline: 1px dotted ButtonText;
}

:-moz-ui-invalid {
	box-shadow: none;
}

legend {
	padding: 0;
}

progress {
	vertical-align: baseline;
}

::-webkit-inner-spin-button,
::-webkit-outer-spin-button {
	height: auto;
}

[type='search'] {
	-webkit-appearance: textfield; 	outline-offset: -2px; }

::-webkit-search-decoration {
	-webkit-appearance: none;
}

::-webkit-file-upload-button {
	-webkit-appearance: button; 	font: inherit; }

summary {
	display: list-item;
}
    </style>
  <style>
      body {
  font-size: 11px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

table tr td {
  padding: 0;
}

table tr td:last-child {
  text-align: right;
}

.bold {
  font-weight: bold;
}

.right {
  text-align: right;
}

.large {
  font-size: 1.55em;
}

.total {
  font-weight: bold;
  color: #fb7578;
}

.logo-container {
  margin: 20px 0 20px 0;
}

.invoice-info-container {
  font-size: 0.875em;
}
.invoice-info-container td {
  padding: 4px 0;
}

.client-name {
  font-size: 1.5em;
  vertical-align: top;
}

.line-items-container {
  margin: 10px 0;
  font-size: 0.875em;
}

.line-items-container th {
  text-align: left;
  color: #999;
  border-bottom: 2px solid #ddd;
  padding: 10px 0 15px 0;
  font-size: 0.75em;
  text-transform: uppercase;
}

.line-items-container th:last-child {
  text-align: right;
}

.line-items-container td {
  padding: 15px 0;
}

.line-items-container tbody tr:first-child td {
  padding-top: 25px;
}

.line-items-container.has-bottom-border tbody tr:last-child td {
  padding-bottom: 25px;
  border-bottom: 2px solid #ddd;
}

.line-items-container.has-bottom-border {
  margin-bottom: 0;
}

.line-items-container th.heading-quantity {
  width: 50px;
}
.line-items-container th.heading-price {
  text-align: right;
  width: 100px;
}
.line-items-container th.heading-subtotal {
  width: 100px;
}

.payment-info {
  width: 38%;
  font-size: 0.75em;
  line-height: 1.5;
}

.footer {
  margin-top: 100px;
}

.footer-thanks {
  font-size: 1.125em;
}

.footer-thanks img {
  display: inline-block;
  position: relative;
  top: 1px;
  width: 16px;
  margin-right: 4px;
}

.footer-info {
  float: right;
  margin-top: 5px;
  font-size: 0.75em;
  color: #ccc;
}

.footer-info span {
  padding: 0 5px;
  color: black;
}

.footer-info span:last-child {
  padding-right: 0;
}

.page-container {
  display: none;
}
.page-break {
    page-break-after: always;
}

.number-clausulas{
    }
.number-clausulas strong{
    float: left;
}
.number-clausulas p{
    margin: 0;
    text-align: justify;
    font-size: small;
}
.number-clausulas strong{
    font-size: small;
}
.place-date{
    text-align: right;
}
.place-date p{
    font-size: small;
}
.header-s{
    background: #c7c7c7cb;
}
.header-s th{
    color: black !important;
}
.section-price-observation td{
    padding: 2px !important;
}
.text-align-price td{
    text-align: initial;
}
  </style>
  {{-- <script type="text/javascript" src="./web/scripts.js"></script> --}}
</head>
<body>

{{-- <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Imprimir Pedido</button> --}}
<div class="web-container">
  <div class="page-container">
    Page
    <span class="page"></span>
    of
    <span class="pages"></span>
  </div>

  <table class="invoice-info-container">
    <tr>
        <td>
            <div class="logo-container">
              <img
                 style="height: 100px; max-height: 100px; object-fit: contain;"
                src="{{ public_path('laravest.png') }}"
              >
            </div>
        </td>
        <td>
            <table class="invoice-info-container">
                <tr>
                  <td>
                   <h1>ORDEN DE COMPRA</h1>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: small;">
                      Fecha Emisión: {{$purchase->date_emision_format}}
                  </td>
                </tr>
                <tr>
                  <td style="font-size: small;">
                      OC-NUM: {{$purchase->created_at->format("Y")}} - {{$purchase->id}}
                  </td>
                </tr>
            </table>
        </td>
    </tr>
  </table>

  <table class="invoice-info-container">
    <tr>
      <td>
       RUC: 85965421784
      </td>
      <td>
      </td>
    </tr>
  </table>

  <table class="invoice-info-container">
    <tr class="header-s">
      <td >
       1.- DATOS DEL PROVEEDOR
      </td>
      <td>
      </td>
    </tr>
    <tr>
        <td>SEÑOR(ES): {{$purchase->provider->full_name}}</td>
        <td>
         N° DE SOLICITUD: <strong>#{{$purchase->id}}</strong>
        </td>
    </tr>

    <tr>
        <td>
            DIRECCIÓN: {{$purchase->provider->address}}
        </td>
        <td>
            T/PAGO: TRANSFERENCIA
        </td>
    </tr>

    <tr>
        <td>
            RUC: <strong> {{$purchase->provider->ruc}} </strong>
        </td>
        <td>
            MONEDA: EUROS
        </td>
    </tr>

    <tr>
        <td>
         TELÉFONO: <strong> {{$purchase->provider->phone}} </strong>
        </td>
        <td>

        </td>
    </tr>

  </table>

  <table class="invoice-info-container">
    <tr class="header-s">
      <td >
       2.- ENTREGA
      </td>
      <td>
      </td>
    </tr>
    <tr>
        <td>DIRECCIÓN: {{$purchase->warehouse->address}} </td>
        <td>
            ALMACEN : <b>{{$purchase->warehouse->name}}</b> 
        </td>
    </tr>

    <tr>
        <td>
           FECHA DE ENTREGA:  {{$purchase->created_at->addDays(3)->format("Y/m/d")}}
        </td>
        <td>
            
        </td>
    </tr>

    <tr>
        <td>
            TELEFONO: <strong> 989785454 </strong>
        </td>
        <td>

        </td>
    </tr>

  </table>

  <table class="line-items-container">
    <thead>
      <tr class="header-s">
        <th class="heading-quantity">#</th>
        <th class="heading-description">PRODUCTO</th>
        <th class="">UNIDAD</th>
        <th class="">P. UNIT</th>
        <th class="">CANT.</th>
        <th class="">TOTAL</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($purchase->purchase_details as $key => $purchase_detail)
            <tr>
                <td>{{$key + 1}}</td>
                <td> {{$purchase_detail->product->title}} </td>
                <td> {{$purchase_detail->unit->name}} </td>
                <td> {{ format_eur($purchase_detail->price_unit) }} </td>
                <td> {{$purchase_detail->quantity}} </td>
                <td> {{ format_eur($purchase_detail->total) }} </td>
            </tr>
        @endforeach
    </tbody>
  </table>


  <table class="line-items-container section-price-observation">
      <tr>
        <td style="padding: 5px;width:75%;">
            <table style="">
                <tbody>
                    <tr>
                        <td >
                            OBSERVACIONES: {{$purchase->description}}
                        </td>
                        <td >
                            <p style="text-align: justify;">
                                
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td style="padding: 5px;">
            <table>
                <tbody class="text-align-price">
                    <tr>
                        <td >
                            IMPORTE:
                        </td>
                        <td >
                          {{ format_eur($purchase->importe) }}
                        </td>
                    </tr>
                    <tr>
                        <td >
                            IVA 21%:
                        </td>
                        <td >
                            {{ format_eur($purchase->igv) }}
                        </td>
                    </tr>
                    <tr>
                        <td >
                          IMPORTE TOTAL:
                        </td>
                        <td >
                            {{ format_eur($purchase->total) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
      </tr>
  </table>

  <table class="line-items-container">
    <tbody>
        <tr>
            <td style="text-align: center;">
                __________________________________
                <br>
                PREPARADO POR
                <br>
                Área de Compras
            </td>
            <td style="text-align: center;">
                __________________________________
                        <br>
                        APROBADO POR
            </td>
        </tr>
        <tr>
        </tr>
    </tbody>
  </table>

</div>

</body></html>
