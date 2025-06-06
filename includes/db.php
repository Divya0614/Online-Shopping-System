<?php
function load_users() {
    if (!file_exists('users.json')) {
        return [];
    }
    $data = file_get_contents('users.json');
    return json_decode($data, true);
}

function save_user($email, $password_hash) {
    $users = load_users();
    $users[$email] = $password_hash;
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
}
?>
