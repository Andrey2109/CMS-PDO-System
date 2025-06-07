<?php
include_once 'init.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isPostRequest()) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['articleIds']) && is_array($data['articleIds'])) {
        $articleIds = $data['articleIds'];
        try {
            $article = new Article();
            $article->deleteMultiple($articleIds);
            $response["success"] = true;
        } catch (Exception $e) {
            $response['message'] = "Error: " . $e->getMessage();
        }
    } else {
        $response['message'] = 'No articles Ids were provided';
    }
} else {
    $response['message'] = "Invalid request method";
}
echo json_encode($response);
