<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\SitioWebController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class FormularioController extends Controller
{
    public $sitioWeb;
    
    public function __construct()
    {
        $this->sitioWeb = new SitioWebController();
    }
    
    // formulario de ejemplo por defecto
    public function formularioAgencia(Request $request) {
        $sitioweb               = json_decode($this->sitioWeb->InfoWebEmpresa());
        $correoempresa          = $sitioweb[0]->email_publico;
        // INFO FORM - agregar las que utilices depende a tu agencia
        $name_contact           = $request->name_contact;
        $email_contact          = $request->email_contact;
        $phone_contact          = $request->phone_contact;
        $message                = $request->message;

        // Agregarlas en el cuerpo del email depende de tus campos
        $bodyMail = '
        <!DOCTYPE html>
        <html lang="es">            
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mensaje Enviado con éxito</title>
        </head>
        <body> 
            <h2>' . $name_contact . ' desea una solicitud especial.  </h2>
            <h2>Solicitud hecha en ""</h2>
            <h4>Información del solicitante:</h4>
            <p>
                <b>Nombre: </b>' . $name_contact . ' <br>
                <b>Telefono: </b>' . $phone_contact . '<br>
                <b>Correo: </b>' . $email_contact . '<br>
                <b>Mensaje: </b><br>' . $message . '<br>';

        $bodyMail .= '</p>
                        <br>
                        <h5>Éxito!</h5>
                    </body>    
                    </html>         
                    ';

        $mail = new PHPMailer(true);
        try {
            // SERVER SETTINGS
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->Host       = 'bookingtech.mx';                   //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'notificaciones@bookingtech.mx';                     //SMTP username
            $mail->Password   = 'Fe!fg8949';                               //SMTP password
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPSecure = "tls";
            $mail->CharSet = 'UTF-8';
            // RECIPIENTES
            $mail->setFrom('notificaciones@bookingtech.com', 'Notificaciones AgenciaNombre');//Nombre de la agencia
            $mail->addAddress($correoempresa);  //Set who the message is to be sent to 
            $mail->addReplyTo($email_contact);
            // MESSAGE
            $mail->Subject = 'Solicitud de informacion - Agencia';  //Set the subject line - Nombre de la agencia
            $mail->AltBody = 'Desean una solicitud especial';    //Replace the plain text body with one created manually
            $mail->isHTML(true);
            $mail->Body = $bodyMail;
            $mail->send();
        } catch (Exception $e) {
            echo $e->errorMessage();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return view('web.graciasAgencia');
    }
}
