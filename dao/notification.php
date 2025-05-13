<?php
require_once 'pdo.php';


function get_notification_count($university_id = null)
{
    $sql = "SELECT COUNT(*) FROM notifications";
    if ($university_id) {
        $sql .= " WHERE university_id = ?";
        return pdo_query_value($sql, $university_id);
    }
    return pdo_query_value($sql);
}


function get_notifications_paginated($limit, $offset, $university_id = null)
{
    $sql = "SELECT n.*, u.name AS university_name
            FROM notifications n
            LEFT JOIN universities u ON n.university_id = u.id";

    if ($university_id) {
        $sql .= " WHERE n.university_id = $university_id";
    }
    $sql .= " ORDER BY n.create_at DESC";
    $sql .= " LIMIT $offset , $limit";



    return pdo_query($sql);
}


function get_notification_by_id($id)
{
    $sql = "SELECT n.*, u.name AS university_name FROM notifications n LEFT JOIN universities u ON n.university_id = u.id WHERE n.id = ?";
    return pdo_query_one($sql, $id);
}


function update_notification($id, $title, $content, $university_id)
{
    $sql = "UPDATE notifications SET title = ?, content = ?, university_id = ? WHERE id = ?";
    pdo_execute($sql, $title, $content, $university_id, $id);
}


function delete_notification($id)
{
    $sql = "DELETE FROM notifications WHERE id = ?";
    pdo_execute($sql, $id);
}


function insert_notification($title, $content, $university_id)
{
    $sql = "INSERT INTO notifications (title, content, university_id, create_at) VALUES (?, ?, ?, NOW())";
    pdo_execute($sql, $title, $content, $university_id);
}
