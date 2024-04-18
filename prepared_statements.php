<?php
include 'connection.php';

function execPreparedStatement($sql, $params) {
    global $conn;
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }

    $result = $stmt->execute();
    $stmt->get_result();
    $stmt->close();

    return $result;
}

?>