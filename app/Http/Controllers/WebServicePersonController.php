<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class WebServicePersonController extends Controller
{
    public function getPersonWebService($code, $type)
    {

        try {
            $validated = Validator::make(
                ['code' => $code, 'type' => $type],
                [
                    'code' => 'required|numeric|digits_between:7,9',
                    'type' => 'required|numeric|in:1,2',
                ],
                [
                    'code.required' => 'El código es requerido',
                    'code.string' => 'El código debe ser numérico',
                    'code.digits_between' => 'El código debe tener entre 7 y 9 dígitos',
                    'type.required' => 'El tipo de persona es requerido',
                    'type.numeric' => 'El tipo de persona debe ser numérico',
                    'type.in' => 'El tipo de persona no es válido',
                ]
            );



            $responseWithErrors = [
                'title' => 'Oops...!',
                'msg' => 'Lo sentimos, ocurrió un error inesperado. Intenta nuevamente más tarde.',
                'error' => [],

            ];

            // throw new Error('Hay problemas');

            if ($validated->fails()) {
                Log::error('Error en la validación de los datos');
                return response()->json(['title' => 'Oops...!', 'msg' => 'Lo sentimos, ocurrió un error inesperado.', 'error' => $validated->errors()], 400);
            }



            // throw new Exception('Error en la validación');

            $urlLogin = env('API_URL', '') . env('ENDPOIN_API_LOGIN', '');

            $urlGetPerson = $type == 1 ? env('ENDPOIN_API_WORKER') : env('ENDPOIN_API_STUDENT');
            $urlGetPerson = env('API_URL', '') . $urlGetPerson;

            $urlLogout = env('API_URL', '') . env('ENDPOIN_API_LOGOUT', '');

            $headers = [
                'Content-Type: application/json',
            ];

            $dataLogin = [
                'email' => env('API_USER', ''),
                'password' => env('API_PASSWORD', ''),
            ];

            $response = $this->requestWebService($urlLogin, $headers, $dataLogin, 'POST');

            if ($response['status'] != 200) {
                Log::error('Error en la autenticación del web service ' .  json_encode($dataLogin) . ' - ' . json_encode($urlLogin));
                $responseWithErrors['error'] = $response;
                return response()->json($responseWithErrors, 500);
            }

            $token = $response['data']->token;

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ];

            $response = $this->requestWebService($urlGetPerson . $code, $headers, []);

            // $msg = 'El código de la persona no existe no existe';
            // Log::error($msg);
            // $responseWithErrors['msg'] = $msg;
            // return response()->json($responseWithErrors, 404);

            if ($response['status'] != 200) {

                if ($response['data']->message == 'El código de trabajador no es válido o no existe') {
                    $msg = 'El código de la persona no existe no existe';
                    Log::error($msg);
                    $responseWithErrors['msg'] = $msg;
                    return response()->json($responseWithErrors, 404);
                }

                Log::error('Error en la obtención de la persona');
                $responseWithErrors['error'] = $response;
                return response()->json($responseWithErrors, 500);
            }

            $dataPerson = $response['data'];

            // Logout from API
            $responseLogout = $this->requestWebService($urlLogout, $headers, []);

            if ($responseLogout['status'] != 200) {
                Log::error('Error en el logout del web service');
                $responseWithErrors['error'] = $responseLogout;
                return response()->json($responseWithErrors, 500);
            }

            // throw new \Exception('Error en la validación');



            return response()->json(['title' => 'Éxito', 'msg' => 'Persona encontrada', 'dataPerson' => $dataPerson, 'type' => $type], 200);
        } catch (Exception $e) {
            Log::error('Error en el proceso de obtención de la persona, ' . $e->getMessage());
            $type = gettype($e);
            $responseWithErrors['error'] = $e;
            return response()->json($responseWithErrors, 500);
        }
    }




    private function requestWebService($url, $headers, $data, $method = 'GET')
    {
        try {
            $payload = json_encode($data);


            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

            $result = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return [
                'data' => json_decode($result),
                'status' => $http_status,
            ];
        } catch (Exception $e) {
            Log::error($e);
            return [
                'data' => null,
                'status' => 0
            ];
        }
    }
}
