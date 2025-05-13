<?php
require_once 'pdo.php';


function get_universities_paginated($limit, $offset)
{
    $sql = "SELECT * FROM universities LIMIT  $offset , $limit";
    return pdo_query($sql);
}

function get_all_universities()
{
    $sql = "SELECT * FROM universities";
    return pdo_query($sql);
}


function get_university_count()
{
    $sql = "SELECT COUNT(*) FROM universities";
    return pdo_query_value($sql);
}


function get_university_by_id($id)
{
    $sql = "SELECT * FROM universities WHERE id = ?";
    return pdo_query_one($sql, $id);
}


function add_university($name)
{
    $sql = "INSERT INTO universities (name) VALUES (?)";
    pdo_execute($sql, $name);
}

function update_university($id, $name)
{
    $sql = "UPDATE universities SET name = ? WHERE id = ?";
    pdo_execute($sql, $name, $id);
}

function delete_university($id)
{
    $conn = null; // Khởi tạo biến kết nối
    try {
        $conn = pdo_get_connection();
        // Bắt đầu giao dịch
        $conn->beginTransaction();

        $sql_check_admin = "SELECT COUNT(*) FROM users WHERE university_id = ? AND role = 'ADMIN'";
        $admin_count = pdo_query_value($sql_check_admin, $id);

        if ($admin_count > 0) {
            throw new Exception("Không thể xóa trường này vì trường có người dùng với vai trò ADMIN.");
        }

        $sql_delete_documents = "DELETE FROM documents WHERE university_id = ?";
        pdo_execute($sql_delete_documents, $id);

        $sql_delete_notifications = "DELETE FROM notifications WHERE university_id = ?";
        pdo_execute($sql_delete_notifications, $id);

        $sql_delete_users = "DELETE FROM users WHERE university_id = ?";
        pdo_execute($sql_delete_users, $id);

        $sql_delete_university = "DELETE FROM universities WHERE id = ?";
        pdo_execute($sql_delete_university, $id);

        // kết thúc giao dịch
        $conn->commit();
        return true;
    } catch (Exception $e) {
        // Hoàn tác giao dịch nếu có lỗi
        if ($conn) {
            $conn->rollBack();
        }
        // Lưu thông báo lỗi vào session để hiển thị
        $_SESSION['error'] = $e->getMessage();
        return false;
    } finally {
        // Đóng kết nối
        if ($conn) {
            unset($conn);
        }
    }
}
