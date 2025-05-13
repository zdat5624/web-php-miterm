<?php
require_once 'pdo.php';

function get_document_count($university_id = null)
{
    $sql = "SELECT COUNT(*) FROM documents";
    if ($university_id) {
        $sql .= " WHERE university_id = ?";
        return pdo_query_value($sql, $university_id);
    }
    return pdo_query_value($sql);
}


function get_documents_paginated_with_university($limit, $offset, $university_id = null, $sort = null, $order = 'ASC')
{
    $sql = "SELECT d.id, d.name, d.link, d.order_number, u.name AS university_name
            FROM documents d
            LEFT JOIN universities u ON d.university_id = u.id";

    if ($university_id) {
        $sql .= " WHERE d.university_id = $university_id";
    }

    if ($sort === 'order_number') {
        $sql .= " ORDER BY d.order_number " . ($order === 'ASC' ? 'ASC' : 'DESC');
    } else {
        $sql .= " ORDER BY d.id DESC";
    }


    $sql .= " LIMIT  $offset , $limit ";


    return pdo_query($sql);
}

function get_document_by_id($id)
{
    $sql = "SELECT d.*, u.name AS university_name FROM documents d LEFT JOIN universities u ON d.university_id = u.id WHERE d.id = ?";
    return pdo_query_one($sql, $id);
}

function update_document($id, $name, $link, $order_number, $university_id)
{
    $sql = "UPDATE documents SET name = ?, link = ?, order_number = ?, university_id = ? WHERE id = ?";
    pdo_execute($sql, $name, $link, $order_number, $university_id, $id);
}

function delete_document($id)
{
    $sql = "DELETE FROM documents WHERE id = ?";
    pdo_execute($sql, $id);
}

function add_document($name, $link, $order_number, $university_id)
{
    $sql = "INSERT INTO documents (name, link, order_number, university_id) VALUES (?, ?, ?, ?)";
    pdo_execute($sql, $name, $link, $order_number, $university_id);
}

function get_max_order_number($university_id)
{
    $sql = "SELECT MAX(order_number) FROM documents WHERE university_id = ?";
    $max = (int)pdo_query_value($sql, $university_id);
    return $max ? $max + 1 : 1;
}
