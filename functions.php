<?php
function getHeritageCount($conn) {
    $sql = "SELECT COUNT(*) AS total FROM heritage_sites";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['total'];
}

function getUserEngagement($conn) {
    $sql = "SELECT COUNT(*) AS total FROM users";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['total'];
}

function getRecentPublishedCount($conn) {
    $sql = "SELECT COUNT(*) AS total FROM heritage_sites WHERE DATE(published_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['total'];
}

function getRecentActivity($conn) {
    $sql = "SELECT description, created_at FROM activity_log ORDER BY created_at DESC LIMIT 5";
    $res = mysqli_query($conn, $sql);
    $output = "";
    while($row = mysqli_fetch_assoc($res)) {
        $days = floor((time() - strtotime($row['created_at'])) / 86400);
        $output .= "<li><span>{$row['description']}</span><span>{$days} days ago</span></li>";
    }
    return $output;
}
?>
