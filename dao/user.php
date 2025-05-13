<?php
require_once 'pdo.php';


function get_all_users()
{
    $sql = "SELECT * FROM users";
    return pdo_query($sql);
}


function get_users_paginated_with_university($limit, $offset)
{
    $sql = "SELECT u.*, uni.name AS university_name 
            FROM users u 
            LEFT JOIN universities uni ON u.university_id = uni.id 
             LIMIT  $offset , $limit ";
    return pdo_query($sql);
}


function get_user_count()
{
    $sql = "SELECT COUNT(*) FROM users";
    return pdo_query_value($sql);
}


function get_user_by_id($id)
{
    $sql = "SELECT * FROM users WHERE id = ?";
    return pdo_query_one($sql, $id);
}


function add_user($email, $password, $name, $role, $university_id)
{
    $sql = "INSERT INTO users (email, password, name, role, university_id) VALUES (?, ?, ?, ?, ?)";
    pdo_execute($sql, $email, $password, $name, $role, $university_id);
}


function update_user($id, $email, $password, $name, $role, $university_id)
{
    $sql = "UPDATE users SET email = ?, password = ?, name = ?, role = ?, university_id = ? WHERE id = ?";
    pdo_execute($sql, $email, $password, $name, $role, $university_id, $id);
}


function delete_user($id)
{
    $sql = "DELETE FROM users WHERE id = ?";
    pdo_execute($sql, $id);
}


function email_exists($email)
{
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    return pdo_query_value($sql, $email) > 0;
}

function user_login($username, $password)
{
    $sql = "SELECT * FROM users WHERE email = ?";
    $user = pdo_query_one($sql, $username);

    if ($user && $user['password'] === $password) {
        return $user;
    }
    return false;
}
