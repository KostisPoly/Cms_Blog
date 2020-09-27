<?php

class Database
{
    private $_database = null;

    public function __construct($database)
    {
        $this->_database = $database;
    }

    public function selectCategories()
    {
        $query = "SELECT * from categories";
        $result = $this->_database->query($query);
        
        while ($row = $result->fetch_assoc()) {

            $query2 = "SELECT cat_title from categories WHERE cat_id =" . $row['cat_parent_cat'] ."";
            $result2 = $this->_database->query($query2)->fetch_row();
            
            if ($result2) {
                $row['cat_parent_cat'] = $result2[0];
            }

            $catArray[] = $row;

        }
        return $catArray;
    }

    public function getSocial() {
        $query = "SELECT * from social";
        $result = $this->_database->query($query);

        $socialArray = [];
        while ($row = $result->fetch_assoc()) {
            $socialArray[] = $row;    
        }
        

        return $socialArray;
    }

    public function getUsers() {
        $query = "SELECT * from users";
        $result = $this->_database->query($query);

        $userArray = [];
        while ($row = $result->fetch_assoc()) {
            $userArray[] = $row;    
        }
        

        return $userArray;
    }

    public function getPosts($action) {
        //except certain categories supposed to be outbound
        if($action == 'admin'){
            $query = "SELECT (SELECT COUNT(*) FROM comments WHERE com_post_id = post_id ) AS count_comments, c.cat_title, p.post_id, p.post_category,
            p.post_title, p.post_author, p.post_date, p.post_image,
            p.post_content, p.post_comments, p.post_tags, p.post_status
            from posts p JOIN categories c ON p.post_category = c.cat_id
            ORDER BY p.post_id DESC";    
        }else{
            $query = "SELECT c.cat_title, p.post_id, p.post_category,
            p.post_title, p.post_author, p.post_date, p.post_image,
            p.post_content, p.post_comments, p.post_tags, p.post_status
            from posts p JOIN categories c ON p.post_category = c.cat_id
            WHERE p.post_category NOT IN (4, 6)
            ORDER BY p.post_id DESC";
        }
        
        $result = $this->_database->query($query);

        $postArray = [];
        while ($row = $result->fetch_assoc()) {
            $postArray[] = $row;
        }
        return $postArray;
    }

    public function getLifePosts() {
        //except certain categories supposed to be outbound
        $query = "SELECT c.cat_title, p.post_id, p.post_category,
            p.post_title, p.post_author, p.post_date, p.post_image,
            p.post_content, p.post_comments, p.post_tags, p.post_status
            from posts p JOIN categories c ON p.post_category = c.cat_id
            WHERE p.post_category = 4";
        $result = $this->_database->query($query);

        $postArray = [];
        while ($row = $result->fetch_assoc()) {
            $postArray[] = $row;
        }
        return $postArray;
    }

    public function getBetPosts() {
        //except certain categories supposed to be outbound
        $query = "SELECT c.cat_title, p.post_id, p.post_category,
            p.post_title, p.post_author, p.post_date, p.post_image,
            p.post_content, p.post_comments, p.post_tags, p.post_status
            from posts p JOIN categories c ON p.post_category = c.cat_id
            WHERE p.post_category = 6";
        $result = $this->_database->query($query);
        
        $postArray = [];
        while ($row = $result->fetch_assoc()) {
            $postArray[] = $row;
        }
        return $postArray;
    }

    public function getPost($postID) {
        $query = "SELECT c.cat_title, p.post_id, p.post_category,
            p.post_title, p.post_author, p.post_date, p.post_image,
            p.post_content, p.post_comments, p.post_tags, p.post_status
            from posts p JOIN categories c ON p.post_category = c.cat_id
            WHERE p.post_id = '".$postID."'";
        $result = $this->_database->query($query);
        $post = $result->fetch_assoc();
        // while ($row = $result->fetch_assoc()) {
        //     $postArray[] = $row;
        // }
        return $post;
    }

    public function getComments() {
        $query = "SELECT p.post_title, c.com_id, c.com_post_id,
            c.com_author, c.com_email, c.com_content, c.com_status,
            c.com_date from comments c JOIN posts p
            ON c.com_post_id = p.post_id";
        $result = $this->_database->query($query);
        
        while ($row = $result->fetch_assoc()) {
            $commentArray[] = $row;
        }
        return $commentArray;
    }

    // public function countComments($postID){
    //     $query = "SELECT * FROM comments WHERE com_post_id = '".$postID."'";
    //     $result = $this->_database->query($query);

    //     $counter = 0;
    //     if($result){
    //         $counter = mysqli_num_rows($result);
    //     }else{
    //         die("INSERTION QUERY FAILED".$result."");
    //     }
    //     return $counter;
    // }

    public function searchTag($tag) {
        $query = "SELECT * from posts WHERE post_tags LIKE '%" . $tag . "%'";
        $result = $this->_database->query($query);
        $searchArray = [];
        
        if ($result) {
            
            while ($row = $result->fetch_assoc()) {
                $searchArray[] = $row;
            }
        }
        
        return $searchArray;
    }

    public function insertCategory($title, $parent){
        $query = "INSERT INTO categories (cat_title, cat_parent_cat) 
                VALUES ('".$title."', '".$parent."')";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function insertPost($category, $title, $author, $date, $image, $content, $tags){
        $query = "INSERT INTO posts (post_category, post_title,
                    post_author, post_date, post_image,
                    post_content, post_tags) 
                    VALUES ('".$category."', '".$title."', '".$author."', '".$date."', '".$image."', '".$content."', '".$tags."')";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function insertComment($post, $author, $email, $content, $date){
        $query = "INSERT INTO comments (com_post_id, com_author, com_email, com_content, com_date) 
                    VALUES ('".$post."', '".$author."', '".$email."', '".$content."', '".$date."')";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function insertUser($username, $password, $firstname, $lastname, $email, $role, $isadmin){
        $options = [
            'cost' => 10,
        ];

        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
        $query = "INSERT INTO users (us_username, us_password, us_firstname, us_lastname, us_email,
                    us_role, us_isadmin) 
                    VALUES ('".$username."', '".$hashed_password."', '".$firstname."', '".$lastname."', '".$email."',
                    '".$role."', '".$isadmin."')";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function updatePost($category, $title, $author, $date, $image, $content, $tags, $status, $edit){
        $query = "UPDATE posts SET post_category = '".$category."', post_title = '".$title."',
                    post_author = '".$author."', post_date = '".$date."', post_image = '".$image."',
                    post_content = '".$content."', post_tags = '".$tags."', post_status =  '".$status."' 
                    WHERE post_id = '".$edit."'";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function updateComment($author, $email, $content, $date, $status, $edit){
        $query = "UPDATE comments SET com_author = '".$author."', com_email = '".$email."',
                    com_content = '".$content."', com_date = '".$date."', com_status = '".$status."' 
                    WHERE com_id = '".$edit."'";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function updateUser($username, $password, $firstname, $lastname, $email, $role, $isadmin, $edit){
        $options = [
            'cost' => 10,
        ];

        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);

        $query = "UPDATE users SET us_username = '".$username."', us_password = '".$hashed_password."',
                    us_firstname = '".$firstname."', us_lastname = '".$lastname."', us_email = '".$email."',
                    us_role = '".$role."', us_isadmin = '".$isadmin."'
                    WHERE us_id = '".$edit."'";
        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }

    }

    public function signUser($username, $password, $firstname, $lastname, $email) {
        $options = [
            'cost' => 10,
        ];

        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
        $query = "INSERT INTO users (us_username, us_password, us_firstname, us_lastname, us_email) 
        VALUES ('".$username."', '".$hashed_password."', '".$firstname."', '".$lastname."', '".$email."')";

        $result = $this->_database->query($query);
        if (!$result) {
            die("INSERTION QUERY FAILED".$result."");
        }
    }
    
    public function loginUser($email, $password){
        
        $query = "SELECT * FROM users WHERE us_email = '".$email."'";
        $result = $this->_database->query($query);

        if($result) {
            
            $row = mysqli_num_rows($result);
            if($row) {
                $user = $result->fetch_assoc();

                $pass_checked = password_verify($password,$user['us_password']);
                
                if($pass_checked && $user['us_password']) {
                    return $user;
                } else {
                    return '';    
                }

            } else {
                return '';
            }

        } else {
            return '';
        }
        
    }

    public function setOnlineUser($username, $sessionID, $datetime, $action){
        $query = "SELECT * FROM cms_online_users WHERE cou_user = '".$username."'";
        $result = $this->_database->query($query);

        if($result){
            $row = mysqli_num_rows($result);

            if($row){
                $userOnline = $result->fetch_assoc();

                if($action == 'login'){
                    echo 'in login';
                    $query = "UPDATE cms_online_users SET cou_session = '".$sessionID."', cou_time = '".$datetime."'";
                    $result = $this->_database->query($query);

                }else{
                    $query = "DELETE FROM cms_online_users WHERE cou_user = '".$username."'";
                    $result = $this->_database->query($query);
                }
                
            }else{
                $query = "INSERT INTO cms_online_users (cou_user, cou_session) VALUES ('".$username."', '".$sessionID."')";
                $result = $this->_database->query($query);
            }
        }else{
            die("INSERTION QUERY FAILED".$result."");
        }
    }

    public function getOnlineUsers(){
        $query = "SELECT * FROM cms_online_users";
        $result = $this->_database->query($query);

        if($result){
            $usersArray = [];
            while ($row = $result->fetch_assoc()) {
                $usersArray[] = $row;
            }
        
        }else{
            die("QUERY FAILED".$result."");
        }
        return $usersArray;
    }
}
