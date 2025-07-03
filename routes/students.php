<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../db.php';

return function ($app) {
    $app->get('/students', function (Request $request, Response $response) {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM students");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($students));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/students', function (Request $request, Response $response) {
        $pdo = getPDO();
        $data = json_decode($request->getBody()->getContents(), true);
        $stmt = $pdo->prepare("INSERT INTO students (firstname, lastname, email) VALUES (?, ?, ?)");
        $stmt->execute([$data['firstname'], $data['lastname'], $data['email']]);
        $response->getBody()->write(json_encode(['message' => 'Étudiant ajouté']));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
