<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../db.php';

return function ($app) {
    // GET /grades - récupérer toutes les notes
    $app->get('/grades', function (Request $request, Response $response) {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM grades");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($students));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // GET /grades/{id} - récupérer une note par son ID
    $app->get('/grades/{id}', function (Request $request, Response $response, $args) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM grades WHERE id = ?");
        $stmt->execute([$args['id']]);
        $grade = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$grade) {
            $response->getBody()->write(json_encode(['error' => 'Note non trouvée']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($grade));
        return $response->withHeader('Content-Type', 'application/json');
    });

// POST /grades - créer une nouvelle note
    $app->post('/grades', function (Request $request, Response $response) {
        $pdo = getPDO();
        $data = json_decode($request->getBody()->getContents(), true);

        // Validation basique
        if (!isset($data['student_id'], $data['subject_id'], $data['grade'], $data['date_taken'])) {
            $response->getBody()->write(json_encode(['error' => 'Données invalides']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $stmt = $pdo->prepare("INSERT INTO grades (student_id, subject_id, grade, date_taken, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$data['student_id'], $data['subject_id'], $data['grade'], $data['date_taken']]);

        $response->getBody()->write(json_encode(['message' => 'Note ajoutée']));
        return $response->withHeader('Content-Type', 'application/json');
    });

// PUT /grades/{id} - mettre à jour une note existante
    $app->put('/grades/{id}', function (Request $request, Response $response, $args) {
        $pdo = getPDO();
        $data = json_decode($request->getBody()->getContents(), true);

        // Validation basique
        if (!isset($data['student_id'], $data['subject_id'], $data['grade'], $data['date_taken'])) {
            $response->getBody()->write(json_encode(['error' => 'Données invalides']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $stmt = $pdo->prepare("UPDATE grades SET student_id = ?, subject_id = ?, grade = ?, date_taken = ? WHERE id = ?");
        $stmt->execute([$data['student_id'], $data['subject_id'], $data['grade'], $data['date_taken'], $args['id']]);

        if ($stmt->rowCount() === 0) {
            $response->getBody()->write(json_encode(['error' => 'Note non trouvée ou pas modifiée']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode(['message' => 'Note mise à jour']));
        return $response->withHeader('Content-Type', 'application/json');
    });

// DELETE /grades/{id} - supprimer une note
    $app->delete('/grades/{id}', function (Request $request, Response $response, $args) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM grades WHERE id = ?");
        $stmt->execute([$args['id']]);

        if ($stmt->rowCount() === 0) {
            $response->getBody()->write(json_encode(['error' => 'Note non trouvée']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode(['message' => 'Note supprimée']));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
