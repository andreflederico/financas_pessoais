<?php
function redirect(string $path): void
{
    header("Location: $path");
    exit;
}

function view(string $path, array $data = []): void
{
    extract($data);
    require __DIR__ . "/../Views/$path.php";
}

if (!function_exists('fetch_url_data')) {
    /**
     * Faz uma requisição GET para uma URL e retorna o conteúdo (geralmente JSON).
     * @param string $url A URL para fazer a requisição.
     * @return array|null O array decodificado do JSON ou null em caso de erro.
     */
    function fetch_url_data(string $url): ?array
    {
        $ch = curl_init(); // Inicia uma sessão cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Define a URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retorna a transferência como string
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos

        $response = curl_exec($ch); // Executa a requisição
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtém o código de status HTTP

        if (curl_errno($ch)) {
            error_log("cURL Error: " . curl_error($ch));
            curl_close($ch);
            return null;
        }

        curl_close($ch); // Fecha a sessão cURL

        if ($httpCode >= 200 && $httpCode < 300) {
            $data = json_decode($response, true); // Decodifica o JSON para um array associativo
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                error_log("JSON Decode Error: " . json_last_error_msg() . " Response: " . $response);
                return null;
            }
        } else {
            error_log("HTTP Error fetching data from " . $url . ": " . $httpCode . " - " . $response);
            return null;
        }
    }
}
