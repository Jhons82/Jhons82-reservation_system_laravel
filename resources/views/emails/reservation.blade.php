<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Confirmación de Reservación</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f7; color: #333;">

        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f7; padding: 40px 0;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); padding: 40px;">
                        
                        <!-- Logo -->
                        {{-- <tr>
                            <td align="center" style="padding-bottom: 20px;">
                                <img src="{{ config('app.url') }}/assets/images/logo_vf.png" alt="J-GOD Logo" height="50" style="display: block;">
                            </td>
                        </tr> --}}

                        <!-- Título -->
                        <tr>
                            <td align="center" style="font-size: 22px; font-weight: bold; color: #2d3748; padding-bottom: 10px;">
                                ¡Reservación Confirmada!
                            </td>
                        </tr>

                        <!-- Saludo -->
                        <tr>
                            <td style="font-size: 16px; line-height: 1.6; padding-bottom: 20px;">
                                Hola <strong>{{ $userName }}</strong>,<br>
                                Tu reservación ha sido confirmada exitosamente. Aquí están los detalles:
                            </td>
                        </tr>

                        <!-- Detalles -->
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 15px; background-color: #f9fafb; border-radius: 6px; padding: 10px;">
                                    <tr><td><strong>👤 Consultor:</strong> {{ $consultantName }}</td></tr>
                                    <tr><td><strong>📅 Fecha:</strong> {{ $reservationDate }}</td></tr>
                                    <tr><td><strong>🕑 Hora de Inicio:</strong> {{ $startTime }}</td></tr>
                                    <tr><td><strong>🕓 Hora de Fin:</strong> {{ $endTime }}</td></tr>
                                    <tr><td><strong>📌 Estado de Reservación:</strong> {{ $reservationStatus }}</td></tr>
                                    <tr><td><strong>💳 Estado de Pago:</strong> {{ $paymentStatus }}</td></tr>
                                    <tr><td><strong>💰 Total de Pago:</strong> {{ $totalAmount }}</td></tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Botón -->
                        <tr>
                            <td align="center" style="padding: 20px 0;">
                                <a href="{{ config('app.url') }}/mis-reservaciones" 
                                style="background-color: #4f46e5; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                                    Ver mis reservaciones
                                </a>
                            </td>
                        </tr>

                        <!-- Despedida -->
                        <tr>
                            <td style="font-size: 14px; color: #555; text-align: center; padding-top: 30px;">
                                Gracias por confiar en <strong>J-GOD</strong>.<br>
                                <span style="font-size: 12px;">Este es un mensaje automático, por favor no respondas a este correo.</span>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>
