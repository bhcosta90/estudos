<?php
require __DIR__.'/../config.php';

function tempoExecucao($start = null) {
    // Calcula o microtime atual
    $mtime = microtime(); // Pega o microtime
    $mtime = explode(' ',$mtime); // Quebra o microtime
    $mtime = $mtime[1] + $mtime[0]; // Soma as partes montando um valor inteiro
    if ($start == null) {
        // Se o parametro n�o for especificado, retorna o mtime atual
        return $mtime;
    } else {
        // Se o parametro for especificado, retorna o tempo de execu��o
        return round($mtime - $start, 2);
    }
}

define('MICRO', tempoExecucao());
define('TEMPO', floatval(time()));

use \app\entities\Usuario;

$app = new Slim\App();

function validarUsuario(){
    $login = $_SERVER['HTTP_AUTHORIZATION'];

    $user = getEm()->getRepository(app\entities\Usuario::class)->findOneByToken($login);

    if(!$user){
        header('Content-Type: text/json');
        http_response_code(403);
        print json_encode([
            "status" => "E",
            "mensagem" => "Credenciais inválidas"
        ]);
        exit;
    }

    return $user;
}

$app->group('/usuario', function () {
    $this->post('/login', function ($request, $response, $args) {

        $login = $_SERVER["PHP_AUTH_USER"] ?? $_POST['client_login'];
        $senha = $_SERVER["PHP_AUTH_PW"] ?? $_POST['client_password'];

        $user = getEm()->getRepository(Usuario::class)->findOneByLogin($login);
        if($user){
            $user = $user->valida($senha);
        }

        if($user){
            getEm()->getConnection()->beginTransaction();
            $user->setToken(rand(1,9999));
            getEm()->flush();
            getEm()->getConnection()->commit();

            return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "S",
                "mensagem" => "Usuário logado com sucesso",
                "user" => [
                    "token" => $user->getToken(),
                ],
            ]));
        }else{
            return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "E",
                "mensagem" => "Usuário inválido"
            ]));
        }
    });

    $this->post('/novo', function ($request, $response, $args) {
        $data = $request->getParsedBody();

        $user = getEm()->getRepository(Usuario::class)->findOneByLogin($email = strtolower($data['login'])) ?? new app\entities\Usuario();

        if($user->getId()){
            return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "E",
                "mensagem" => "Usuário já cadastrado em nosso sistema",
                "tempo" => [
                    "total" => tempoExecucao(MICRO),
                    "inicio" => MICRO,
                    "fim" => floatval(microtime())
                ]
            ]));
        }else{

            $user->setLogin($data["login"]);
            $user->setSenha($data["senha"]);

            getEm()->persist($user);
            getEm()->flush();

            // try{
                // $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                // $mail->isSMTP();                                      // Set mailer to use SMTP
                // $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                // $mail->SMTPAuth = true;                               // Enable SMTP authentication
                // $mail->Username = 'bhcosta90@gmail.com';                 // SMTP username
                // $mail->Password = 'ma03012013';                           // SMTP password
                // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                // $mail->Port = 587;                                    // TCP port to connect to
                //
                // //Recipients
                // $mail->setFrom('bhcosta90@gmail.com', 'Bruno Costa');
                // $mail->addAddress($email);     // Add a recipient
                // // $mail->addAddress('ellen@example.com');               // Name is optional
                // // $mail->addReplyTo('info@example.com', 'Information');
                // // $mail->addCC('cc@example.com');
                // // $mail->addBCC('bcc@example.com');
                //
                // //Attachments
                // // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                //
                // //Content
                // $mail->isHTML(true);                                  // Set email format to HTML
                //
                // $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                // $domainName = $_SERVER['HTTP_HOST'];
                //
                // $link = $protocol.$domainName."/usuario/ativar-conta?token=" . base64_encode($user->getSenha());
                //
                // $msg = "<h3>Olá, seja bem vindo</h3>";
                // $msg .= "<p>Ocorreu um cadastro em nosso site para o e-mail: $email.</p>";
                // $msg .= "<p>Se acaso não foi solicitado por você, favor desconsiderar esse e-mail.</p>";
                // $msg .= "<p>Par ativa seu e-mail em nosso site, favor <a href='{$link}'>clique aqui</a>.</p>";
                //
                // $mail->Subject = utf8_decode('Ativação de Conta');
                // $mail->Body    = $msg;
                // $mail->AltBody = 'Ativação de conta';
                //
                // $mail->send();

                return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode([
                    "status" => "S",
                    "mensagem" => "Usuário cadastrado com sucesso",
                    "tempo" => [
                        "total" => tempoExecucao(MICRO),
                        "inicio" => MICRO,
                        "fim" => floatval(microtime())
                    ]
                ]));

            // }catch(\PHPMailer\PHPMailer\Exception $e){
            //     return $response
            //     ->withStatus(200)
            //     ->withHeader('Content-Type', 'application/json')
            //     ->write(json_encode([
            //         "status" => "E",
            //         "mensagem" => $mail->ErrorInfo,
            //
            //     ]));
            // }
        }
    });
});

$app->group('/automovel', function(){
    $this->post('/novo', function ($request, $response, $args) {

        if($user = validarUsuario()){
            return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "S",
                "mensagem" => $user->getId(),
            ]));
        }
    });
});

$app->run();
?>
