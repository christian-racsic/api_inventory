<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
  <title>Descargar Venta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    *,*::before,*::after{box-sizing:border-box}
    :root{-moz-tab-size:4;tab-size:4}
    html{line-height:1.15;-webkit-text-size-adjust:100%}
    body{margin:0;font-family:system-ui,-apple-system,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji'}
    hr{height:0;color:inherit}
    abbr[title]{text-decoration:underline dotted}
    b,strong{font-weight:bolder}
    code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Consolas,'Liberation Mono',Menlo,monospace;font-size:1em}
    small{font-size:80%}
    sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}
    sub{bottom:-.25em} sup{top:-.5em}
    table{text-indent:0;border-color:inherit;border-collapse:collapse;width:100%}
    button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}
    button,select{text-transform:none}
    [type='button'],[type='reset'],[type='submit']{-webkit-appearance:button}
    ::-moz-focus-inner{border-style:none;padding:0}
    :-moz-focusring{outline:1px dotted ButtonText}
    :-moz-ui-invalid{box-shadow:none}
    legend{padding:0}
    progress{vertical-align:baseline}
    ::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}
    [type='search']{-webkit-appearance:textfield;outline-offset:-2px}
    ::-webkit-search-decoration{-webkit-appearance:none}
    ::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}
  </style>

  <style>
    body{font-size:13px}
    table tr td{padding:0}
    table tr td:last-child{text-align:right}
    .bold{font-weight:bold}
    .right{text-align:right}
    .large{font-size:1.2em}
    .total{font-weight:bold;color:#fb7578}
    .logo-container{margin:20px 0 30px 0}
    .invoice-info-container{font-size:.875em}
    .invoice-info-container td{padding:4px 0}
    .client-name{font-size:1.5em;vertical-align:top}
    .line-items-container{margin:15px 0;font-size:.875em}
    .line-items-container th{text-align:left;color:#999;border-bottom:2px solid #ddd;padding:10px 0 15px 0;font-size:.75em;text-transform:uppercase}
    .line-items-container th:last-child{text-align:right}
    .line-items-container td{padding:5px 0}
    .line-items-container.has-bottom-border tbody tr:last-child td{padding-bottom:25px;border-bottom:2px solid #ddd}
    .line-items-container.has-bottom-border{margin-bottom:0}
    .line-items-container th.heading-quantity{width:50px}
    .line-items-container th.heading-price{text-align:right;width:100px}
    .line-items-container th.heading-subtotal{width:100px}
    .payment-info{width:38%;font-size:.75em;line-height:1.5}
    .footer{margin-top:30px}
    .footer-thanks{font-size:1.125em}
    .footer-thanks img{display:inline-block;position:relative;top:1px;width:16px;margin-right:4px}
    .footer-info{float:right;margin-top:5px;font-size:.75em;color:#ccc}
    .footer-info span{padding:0 5px;color:black}
    .footer-info span:last-child{padding-right:0}
    .page-container{display:none}
    .page-break{page-break-after:always}
    .number-clausulas p{margin:0;text-align:justify;font-size:.76rem}
    .number-clausulas strong{float:left;font-size:.76rem}
    .number-clausulas ul li{font-size:.76rem}
    .place-date{text-align:right}
    .place-date p{font-size:.6rem}
  </style>
</head>
<body>
@php
  $safe = function ($obj, string $path, $default='-') {
      $v = data_get($obj, $path);
      if ($v === null) return $default;
      if (is_string($v)) return trim($v) !== '' ? $v : $default;
      return $v !== '' ? $v : $default;
  };
  $money = function ($n) {
      if ($n === null || $n === '') return '€ 0,00';
      return '€ '.number_format((float)$n, 2, ',', '.'); // formato ES
  };
  $fmtDate = function ($dt, $format = 'Y/m/d') {
      try {
          return $dt ? \Carbon\Carbon::parse($dt)->format($format) : '-';
      } catch (\Throwable $e) {
          return '-';
      }
  };
  $asesor = trim(($safe($sale,'user.full_name','') ?: trim($safe($sale,'user.name','').' '.$safe($sale,'user.surname',''))));
  if ($asesor==='') $asesor='-';
@endphp

<div class="web-container">
  <div class="page-container">
    Page <span class="page"></span> of <span class="pages"></span>
  </div>

  <div class="logo-container">
    <table>
      <tbody>
        <tr>
          <td style="padding:0 !important;border-bottom:none;">
            N° {{ (int)($sale->state_sale ?? 1) === 1 ? 'VENTA' : 'COTIZACION' }}: <strong>#{{ $safe($sale,'id') }}</strong>
            <br>
            <img  style="height: 100px; max-height: 100px; object-fit: contain;" src="{{ public_path('laravest.png') }}">
            <br>
            <small>https://www.laravest.com/</small>
            <br>
            <small>echodeveloper960@gmail.com</small>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div style="clear:both;"></div>

  <table class="invoice-info-container">
    <tr>
      <td>
        N° {{ (int)($sale->state_sale ?? 1) === 1 ? 'VENTA' : 'COTIZACION' }}:
        <strong>#{{ $safe($sale,'id') }}</strong>
      </td>
      <td>
        FECHA CONTRATO: {{ $fmtDate($safe($sale,'created_at'), 'Y/m/d') }}
      </td>
    </tr>

    <tr>
      <td>
        <b>Datos del cliente: </b><br><br>
        CLIENTE: {{ $safe($sale,'client.full_name') }}<br>
        DEPART./PROVINCIA CLIENTE:
        <strong>
          {{ $safe($sale,'client.region') }}/{{ $safe($sale,'client.provincia') }}/{{ $safe($sale,'client.distrito') }}
        </strong>
      </td>
      <td>
        {{ $safe($sale,'client.type_document','DOC') }}:
        {{ $safe($sale,'client.n_document') }}
      </td>
    </tr>

    <tr>
      <td>
        @php $tipoCli = (int) $safe($sale,'client.type_client',1); @endphp
        TIPO CLIENTE: {{ $tipoCli === 1 ? 'CLIENTE FINAL' : 'CLIENTE EMPRESA' }}
      </td>
      <td>TELÉFONO: {{ $safe($sale,'client.phone') }}</td>
    </tr>

    <tr>
      <td>
        DIRECCIÓN: <strong>{{ $safe($sale,'sucursale.address') }}</strong><br>
        SUCURSAL DE ATENCION: <strong>{{ $safe($sale,'sucursale.name') }}</strong>
      </td>
      <td></td>
    </tr>

    <tr>
      <td>VENDEDOR: <strong>{{ $asesor }}</strong></td>
      <td>TELÉFONO: {{ $safe($sale,'user.phone') }}</td>
    </tr>
  </table>

  <table class="line-items-container">
    <thead>
      <tr>
        <th class="heading-quantity">Qty</th>
        <th class="heading-description">Descripción</th>
        <th class="heading-price">Subtotal</th>
        <th class="heading-subtotal">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($sale->sale_details ?? [] as $sale_detail)
        @php
          $qty = $safe($sale_detail,'quantity',0);
          $prodTitle = $safe($sale_detail,'product.title');
          $catTitle  = $safe($sale_detail,'product.product_categorie.title');
          $descLine  = $safe($sale_detail,'description','-');
          $subLine   = $money($safe($sale_detail,'subtotal',0));
          $totLine   = $money($safe($sale_detail,'total',0));
        @endphp
        <tr>
          <td>{{ $qty }}</td>
          <td>
            {{ $prodTitle }}<br>
            Categoria: {{ $catTitle }}<br>
            Descripción: {{ $descLine }}
          </td>
          <td class="right">{{ $subLine }}</td>
          <td class="bold">{{ $totLine }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <table class="line-items-container has-bottom-border">
    <thead>
      <tr>
        <th>Metodo de Pago</th>
        <th>Fecha Entrega</th>
        <th>Información de Pago</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="payment-info">
          <div>
            METODO DE PAGO:
            <strong>
              @php
                $mp = $safe($sale,'first_payment.method_payment',null);
                $am = $safe($sale,'first_payment.amount',null);
              @endphp
              {{ $mp ? $mp : '-' }}
              {{ $am ? $money($am) : '' }}
            </strong>
          </div>
        </td>
        <td class="large">
          @php $fechaVal = $safe($sale,'date_validation',null); @endphp
          {{ $fechaVal ? $fmtDate($fechaVal, 'Y/m/d h:i A') : '-' }}
        </td>
        <td class="payment-info">
          <div class="large total">
            TOTAL: {{ $money($safe($sale,'total',0)) }}<br>
            DESCUENTO: - {{ $money($safe($sale,'discount',0)) }}
          </div>
          <div>
            ADELANTADO: <strong>{{ $money($safe($sale,'paid_out',0)) }}</strong>
          </div>
          <div>
            SALDO: <strong>{{ $money($safe($sale,'debt',0)) }}</strong>
          </div>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="footer">
    <div class="footer-info">
      <span> ANOTACIONES FINALES: {{ $safe($sale,'description','-') }} </span>
    </div>
  </div>
</div>
</body>
</html>
