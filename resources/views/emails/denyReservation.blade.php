 {{-- Plantilla para enviar el correo de bienvenida al sistema --}}
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Estado de la reservación</title>
 </head>
 

 <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

     <table
         style="max-width: 650px;
         margin: 0 auto;
         background-color: #ffffff;
         border-radius: 5px;
         padding: 20px;">
         <tr
             style="background-color: #CD5700;
         border-radius: 8px 8px 0 0;
         padding: 5px;
         text-align: center;">
             <td>
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
                     </strong> <i> no ha sido aceptada</i>.
                 </p>

                 <p
                     style="text-align: center;
         margin-top: 25px;
         margin-bottom: 25px;
         font-size: 1rem;">
                     El motivo por el que se rechazó su petición es el siguiente: <br>
                     <strong> {{ $Motivo }}</strong>
                 </p>

                 <p> Si tienes alguna duda cumunicate a la extensión: <strong>56881</strong>. </p>

                 <p>Saludos cordiales,<br> &emsp; &emsp; <i>Agenda CUAltos</i> .</p>
             </td>
         </tr>
         <tr>
             <td style="background-color: #CD5700;
         border-radius: 5px 5px 0 0;
         padding: 10px;
         text-align: center;
         color: white;">
                 <p style="font-size: 0.8rem;
         padding-left: 15px;
         padding-right: 15px;"> Desarrollado por <a style="text-decoration: none;
         color: white;" href="https://cta.cualtos.udg.mx/"><b> CTA CUAltos</b> </a>,
                     consulta nuestra <a style="text-decoration: none;
         color: white;" href="https://udg.mx/politica-de-privacidad-y-manejo-de-datos"> <b>Política de
                             privacidad </b>
                         y <b> manejo de datos.</b></a></p>
             </td>
         </tr>
     </table>

 </body>

 </html>
