 {{-- Plantilla para enviar el correo de bienvenida al sistema --}}
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Estado de la reservación</title>
 </head>
 <style>
     .emailheader {
         max-width: 650px;
         margin: 0 auto;
         background-color: #ffffff;
         border-radius: 5px;
         padding: 20px;
     }

     .headercontent {}

     .emailfooter {
         background-color: #CD5700 !important;
         border-radius: 5px 5px 0 0;
         padding: 10px;
         text-align: center;
         color: white;
     }

     .pfooter {
         font-size: 0.8rem;
         padding-left: 15px;
         padding-right: 15px;
     }

     .pfooter a {
         text-decoration: none;
         color: white
     }

     p {
         line-height: 25px;
     }

     .reason_text {
         text-align: center;
         margin-top: 25px;
         margin-bottom: 25px;
         font-size: 1rem;
     }


     .logo {
         width: 100%;
         max-width: 220px;
         height: auto;
         display: block;
         margin: 0 auto;
     }
 </style>

 <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">



     <table
         style="max-width: 650px;
         margin: 0 auto;
         background-color: #ffffff;
         border-radius: 5px;
         padding: 20px;">
         <tbody>
             <tr>
                 <td
                     style=" background-color: #CD5700 !important;
                 border-radius: 8px 8px 0 0;
                 padding: 5px;
                 text-align: center;">
                     <img class="logo" src="{{ $message->embed('img/logo-agenda.png') }}" alt="Logo Agenda CUAltos">
                 </td>
             </tr>


             <tr>
                 <td>
                     <p>Estimad@ <strong>{{ $event->responsible->name }}</strong></p>
                     <p class="main-text">Por medio de este correo le hacemos saber que su reservación del aula
                         <strong>{{ $event->place->name }}
                         </strong> para la fecha <strong>
                             {{ $event->date->start_date_formatted . ' con el horario de ' . $event->date->start_hour . ' a ' . $event->date->end_hour }}
                         </strong> <i> ha sido aceptada para su {{ $event->event_type->name }} </i>.
                     </p>

                     <p> Si tienes alguna duda cumunicate a la extensión: <strong>56881</strong>. </p>

                     <p>Saludos cordiales,<br> &emsp; &emsp; <i>Agenda CUAltos</i> .</p>
                 </td>
             </tr>
             <tr>
                 <td
                     style="background-color: #CD5700 !important;
         border-radius: 5px 5px 0 0;
         padding: 10px;
         text-align: center;
         color: white;">
                     <p style=" text-decoration: none;
         color: white"> Desarrollado por <a
                             style="text-decoration: none;
         color: white;"
                             href="https://cta.cualtos.udg.mx/"><b> CTA CUAltos</b>
                         </a>,
                         consulta nuestra <a style="text-decoration: none;
         color: white;"
                             href="https://udg.mx/politica-de-privacidad-y-manejo-de-datos"> <b>Política
                                 de
                                 privacidad </b>
                             y <b> manejo de datos.</b></a></p>
                 </td>
             </tr>
         <tbody>
     </table>


 </body>

 </html>
