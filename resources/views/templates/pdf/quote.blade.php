<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Presupuesto {{ $quote->number }}</title>
    
    <style type="text/css">

      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      /*fonts*/


      /*All the styling goes here*/
      footer {
          position: fixed; 
          bottom: -40px; 
          left: 0px; 
          right: 0px;
          height: 30px; 

          /** Extra personal styles **/
          /*background-color: #03a9f4;*/
          color: #B7B7B7;
          text-align: center;
          line-height: 25px;
      }
      header{
        position:fixed;
        color: #193656;
        top:-20px;
        width: 100%;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;  
      }
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; 
        max-height: 100%; 
      }

      body {
        background-color: #ffffff;
        
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin-top:50px;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;        
      }

      table {
        border-collapse: collapse;
        opacity: 0.075;
        background-position: center;
        background-repeat: no-repeat;
        background-size: 384px 225px;
        /*mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;*/
        width: 100%; }
      table tr td {
          font-family: sans-serif;
          font-size: 9px;
          vertical-align: middle;
          padding-top:1px;
          padding-bottom:1px;
      }
      table tr th {
          padding-top:3px;
          padding-bottom:3px;
          font-family: sans-serif;
          font-size: 10px;
          font-weight: 400;
          vertical-align: middle;
          background-color: #cccccc;
      }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */
/*
      .body {
        background-color: #ffffff;
        width: 100%; 
      }
*/
      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        /*display: block;*/
        /*margin: 0 auto !important;*/
        /* makes it centered */
        max-width: 1000px;
        padding: 20px 10px;
        width: 1000px; 
      }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        /*display: block;*/
        margin: 0 auto;
        max-width: 580px;
        padding: 10px; 
      }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #f6f6f6;
        border-radius: 3px;
        width: 100%; 
      }

      .seccion{
        background-color: #f1f1f1;
        border-radius: 20px 20px 20px 20px;
        width: 100%;
        margin: 50px 0px;
        border: 1px solid #e0e0e0;
        page-break-inside: avoid;
      }

      .seccion-notas{
        background-color: #ffffff;
        width: 100%;
        margin: 50px 0px;
        border: 1px solid #e0e0e0;
        page-break-inside: avoid;
      }
      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }


      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4,
      h5, {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.3;
        margin: 0;
        margin-bottom: 5px;
        margin-top: 10px; 
        text-align: center;
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 9px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 10px;
        margin-left:0px;
        padding-left:0px;
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 2px; 
          font-style: italic;
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }



      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }

      .align-right {
        text-align: right; 
      }

      .align-left {
        text-align: left; 
      }

      .clear {
        clear: both; 
      }

      .mt0 {
        margin-top: 0; 
      }

      .mb0 {
        margin-bottom: 0; 
      }

      .preheader {
        color: transparent;
        /*display: none;*/
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; 
      }

      .powered-by a {
        text-decoration: none; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0; 
      }


      }
    </style>
  </head>
  
    <header>
        <table>
            <tbody>
                <tr>
                    <td width="20%" style="font-size: 11px;">
                        <div>
                            <img src="{{ Vite::asset('resources/images/logo.png') }}" width="81px" height="60px">
                        </div>
                    </td>
                    <td>
                        <div><b>{{ $company->name}}</b></div>
                        <div>RUC: {{ $company->ruc}}</div>
                        <div>{{ $company->address}} - {{ $company->district}} - Telf.:{{ $company->phone}}</div>
                    </td>
                    <td style="font-size: 12px;text-align:right;vertical-align:top;">
                        <div style="font-size:11px;font-style:italic;">{{ $quote->created_date }}</div>
                        <div style="font-weight:700;">PRESUPUESTO</div>
                        <div style="font-size:11px;font-weight:700;">No. {{ $quote->number }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>
    <body>
        <table>
            <tbody>
                <tr>
                    <td colspan="3" width="75%" style="font-size: 11px;">
                        <b>Cliente: {{ $quote->name}}</b><br>
                    </td>
                    <td colspan="1" width="25%" style="font-size: 11px;">
                        {{ $quote->document_type }}:
                        @if (!is_null($quote->document_number)&&$quote->document_number!=='')
                            &nbsp;{{ $quote->document_number }}<br>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="font-size: 9px;">
                        Dirección:
                        @if (!is_null($quote->address)&&$quote->address!=='')
                            &nbsp;{{ $quote->address }}<br>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" width="50%" style="font-size: 9px;">
                        Telef:
                        @if (!is_null($quote->phone)&&$quote->phone!=='')
                            &nbsp;{{ $quote->phone }}
                            @if (is_null($quote->email)||$quote->email==='')
                                <br>
                            @endif
                        @endif
                    </td>
                    <td colspan="2" width="50%" style="font-size: 9px;">
                        E-mail:
                        @if (!is_null($quote->email)&&$quote->email!=='')
                            &nbsp;{{ $quote->email }}<br>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 9px;">
                        Atención a::
                        @if (!is_null($quote->contact)&&$quote->contact!=='')
                            &nbsp;{{ $quote->contact }}<br>
                        @endif
                    </td>
                    <td colspan="2" style="font-size: 9px;">
                        Referencia:
                        @if (!is_null($quote->reference)&&$quote->reference!=='')
                            &nbsp;{{ $quote->reference }}<br>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="25%" style="font-size: 9px;">
                        Marca:
                        @if (!is_null($quote->brand)&&$quote->brand!=='')
                            &nbsp;{{ $quote->brand }}
                        @endif
                    </td>
                    <td width="25%" style="font-size: 9px;">
                        Motor:
                        @if (!is_null($quote->motor)&&$quote->motor!=='')
                            &nbsp;{{ $quote->motor }}
                        @endif
                    </td>
                    <td colspan="2" width="50%" style="font-size: 9px;text-align:right;vertical-align:top;">
                        @if (!is_null($quote->scheduled_date))
                        <div>Fecha Programada:&nbsp;{{ $quote->scheduled_date }}</div>
                        @endif
                        @if (!is_null($quote->executed_date))
                        <div>Fecha Realizada:&nbsp;{{ $quote->executed_date }}</div>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Grupo</th>
                <th>Descripción</th>
                <th>Medida</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Parcial</th>
            </tr>
            <tbody>
                @foreach ($quote->services as $service)
                    <tr @if (($loop->index % 2) !== 0)
                            style="background-color:#f2f2f2;"
                        @endif
                    >
                        <td>{{ $loop->index+1 }}</td>
                        <td style="text-align:center;">{{ $service->code }}</td>
                        <td>{{ $service->group_name }}</td>
                        <td>{{ $service->description }}</td>
                        <td style="text-align:center">{{ $service->measure }}</td>
                        <td style="text-align:center">{{ $service->quantity }}</td>
                        <td style="text-align:right">{{ number_format($service->unit_price,2) }}</td>
                        <td style="text-align:right">{{ number_format($service->subtotal,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table style="margin-bottom: 20px;">
            <tr>
                <td width="75%" style="vertical-align:top;padding-right:20px;">
                    <h4>REPUESTOS A TRAER</h4>
                    <table>
                        <tr>
                            <th>#</th>
                            <th style="font-size:9px;">Descripción</th>
                            <th style="font-size:9px;">Medida</th>
                            <th style="font-size:9px;">Cantidad</th>
                        </tr>
                        <tbody>
                            @foreach ($quote->parts as $part)
                                <tr @if (($loop->index % 2) !== 0)
                                        style="background-color:#f2f2f2;"
                                    @endif
                                >
                                    <td style="font-size:7px;">{{ $loop->index+1 }}</td>
                                    <td style="font-size:7px;">{{ $part->description }}</td>
                                    <td style="font-size:7px;text-align:center">{{ $part->measure }}</td>
                                    <td style="font-size:7px;text-align:center">{{ $part->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td width="25%" style="vertical-align:top;padding-top:26px;">
                    <table>
                        <tr style="border-top:1px solid #f2f2f2;">
                            <td style="background-color: #f2f2f2;font-weight:700;font-size:10px;padding:3px;">SUBTOTAL</td>
                            <td style="text-align:right;font-weight:700;font-size:10px;">{{ $quote->symbol }} {{ number_format($quote->subtotal,2) }}</td>
                        </tr>
                        <tr style="border-top:1px solid #f2f2f2;">
                            <td style="background-color: #f2f2f2;font-weight:700;font-size:10px;padding:3px;">IGV</td>
                            <td style="text-align:right;font-weight:700;font-size:10px;">{{ $quote->symbol }} {{ number_format($quote->igv,2) }}</td>
                        </tr>
                        <tr style="border-top:1px solid #f2f2f2;">
                            <td style="background-color: #f2f2f2;font-weight:700;font-size:11px;padding:3px;">TOTAL</td>
                            <td style="text-align:right;font-weight:700;font-size:11px;">{{ $quote->symbol }} {{ number_format($quote->total,2) }}</td>
                        </tr>
                        @if ($quote->payday>0)
                            <tr>
                                <td colspan="2" style="font-size:8px;font-weight:700;">
                                    <div class="align-right">VALIDEZ DE LA OFERTA:{{ $quote->payday}} DÍAS</div>
                                </td>
                            </tr>                            
                        @endif

                    </table>
                </td>
            </tr>
        </table>
        @if (count($quote->notes)>0)
        <h5>NOTAS</h5>
        <ul>
            @foreach ($quote->notes as $note)
            <li>
                {{ $note->description }}
            </li>
            @endforeach
        </ul>           
        @endif
        <div style="font-size:9px;margin-top:20px;">IMPORTANTE:</div>
        <ul>
            <li>{{$quote_important_note_1}}</li>
            <li>{{$quote_important_note_2}}</li>
            <li>{{$quote_important_note_3}}</li>
        </ul>
        <div style="font-size:9px;margin-top:20px;">CONTACTO ASESORES DE SERVICIO: {{ $quote_contact_consultants }}</div>
    </body>
        <footer>
        WS Rectificaciones &copy; <?php echo date("Y");?> 
        </footer>
  
</html>